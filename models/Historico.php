<?php
require_once "./config/database.php";

class Historico{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
   
}