    <?php

    require_once __DIR__ . "/../config/Database.php";


    class Chamados
    {
        private $conn;
        private $tableChamados = "chamados";

        public function __construct()
        {
            $database = new Database();
            $this->conn = $database->connect();
        }

        public function cadastroChamado($descricao, $tipo_incidente, $id_usuario)
        {
            $sql = "INSERT INTO {$this->tableChamados} (id_usuario, descricao, tipo_incidente, status, data_abertura)
                    VALUES (:id_usuario, :descricao, :tipo_incidente, :status, NOW())";
            $query = $this->conn->prepare($sql);
            $status = "Aberto";
            $id_usuario = $_SESSION["id_usuario"];

            $query->bindParam(":id_usuario", $id_usuario);
            $query->bindParam(":descricao", $descricao);
            $query->bindParam(":tipo_incidente", $tipo_incidente);
            $query->bindParam(":status", $status);

            if ($query->execute()) {
                $_SESSION["id_chamado"] = $this->conn->lastInsertId();
            }
            return false;
        }

        public function selectChamados()
        {
            $sql = "SELECT * FROM {$this->tableChamados}";
            $query = $this->conn->prepare($sql);
            $query->execute();
            $chamados = $query->fetchAll(PDO::FETCH_ASSOC);

            if ($chamados) {
                return $chamados;
            }
            return false;
        }
    }
