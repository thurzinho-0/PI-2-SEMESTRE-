<?php

class Categoria
{

    private $conn;
    private $tabela_categoria = "categoria";
    public $nome;
    public $id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function categoriaExiste()
    {
        $query = "SELECT id FROM " . $this->tabela_categoria . " WHERE nome = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->nome);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function criar()
    {
        if ($this->CategoriaExiste()) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabela_categoria . " (nome) VALUES (?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bind_param("s", $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function listar()
    {
        $query = "SELECT * FROM " . $this->tabela_categoria . " ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    public function excluir()
    {
        $query = "DELETE FROM " . $this->tabela_categoria . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function buscaID()
    {
        $query = "SELECT * FROM " . $this->tabela_categoria . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            return $row;
        }
        return false;
    }

    public function editar()
    {
        $query = "UPDATE " . $this->tabela_categoria . " SET nome = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $this->nome, $this->id);
        if ($stmt->execute()){
            return true;
        }
        return false;
    }
}
