-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/03/2025 às 23:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12
CREATE DATABASE chamados_ti;
USE chamados_ti;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `chamados_ti`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anexos`
--

CREATE TABLE `anexos` (
  `id` int(11) NOT NULL,
  `id_chamado` int(11) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `tipo_arquivo` varchar(50) NOT NULL,
  `arquivo_base64` longtext NOT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `tipo_incidente` enum('Hardware','Software','Rede','Outros') NOT NULL,
  `status` enum('Aberto','Em Andamento','Fechado') DEFAULT 'Aberto',
  `data_abertura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contatos_chamado`
--

CREATE TABLE `contatos_chamado` (
  `id` int(11) NOT NULL,
  `id_chamado` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `emails_enviados`
--

CREATE TABLE `emails_enviados` (
  `id` int(11) NOT NULL,
  `email_destino` varchar(255) NOT NULL,
  `codigo_verificacao` varchar(6) NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_chamado`
--

CREATE TABLE `historico_chamado` (
  `id` int(11) NOT NULL,
  `id_chamado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anexos`
--
ALTER TABLE `anexos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chamado` (`id_chamado`);

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `contatos_chamado`
--
ALTER TABLE `contatos_chamado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chamado` (`id_chamado`);

--
-- Índices de tabela `emails_enviados`
--
ALTER TABLE `emails_enviados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_chamado`
--
ALTER TABLE `historico_chamado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chamado` (`id_chamado`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anexos`
--
ALTER TABLE `anexos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contatos_chamado`
--
ALTER TABLE `contatos_chamado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `emails_enviados`
--
ALTER TABLE `emails_enviados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_chamado`
--
ALTER TABLE `historico_chamado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anexos`
--
ALTER TABLE `anexos`
  ADD CONSTRAINT `anexos_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `chamados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `contatos_chamado`
--
ALTER TABLE `contatos_chamado`
  ADD CONSTRAINT `contatos_chamado_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `historico_chamado`
--
ALTER TABLE `historico_chamado`
  ADD CONSTRAINT `historico_chamado_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historico_chamado_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
