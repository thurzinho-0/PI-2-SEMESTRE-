<?php

require_once __DIR__ . '/../config/database.php';

class Database
{

    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $this->conn->set_charset("utf8");
        } catch (Exception $e) {
            die("Erro de conexão: " . $e->getMessage());
        }

        return $this->conn;
    }
}
