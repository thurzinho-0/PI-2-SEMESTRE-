<?php

class Produto
{

    private $conn;
    private $tabela_produto = "produto_anuncio";
    public $nome;
    public $descricao;
    public $preco;
    public $fk_categoria_id;
    public $status;
    public $id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Metodo de verificação de produto existente
    public function produtoExiste()
    {
        $query = "SELECT id FROM " . $this->tabela_produto . " WHERE nome = ? LIMIT 1";

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

    //Metodo de criação de produto
    public function criar()
    {
        if ($this->ProdutoExiste()) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabela_produto . " (nome, descricao, fk_categoria_id, preco) VALUES (?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $stmt->bind_param("ssid", $this->nome, $this->descricao, $this->fk_categoria_id, $this->preco);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Metodo de listagem de produto
    public function listarAtivos()
    {
        $query = "SELECT p.id, 
                        p.nome, 
                        p.descricao, 
                        p.preco, 
                        p.status, 
                        p.fk_categoria_id, 
                        c.nome as nome_categoria FROM " . $this->tabela_produto . " p LEFT JOIN categoria c ON p.fk_categoria_id = c.id WHERE p.status = 1 ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de exclusão de produto
    public function excluir()
    {
        $query = "DELETE FROM " . $this->tabela_produto . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de busca de produto usando id
    public function buscaID()
    {
        $query = "SELECT p.*, 
                        c.nome as  nome_categoria FROM " . $this->tabela_produto .  " p LEFT JOIN categoria c ON p.fk_categoria_id = c.id WHERE p.id = ? LIMIT 1";
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

    //Metodo de edição de produto
    public function editar()
    {
        $query = "UPDATE " . $this->tabela_produto . " SET nome = ?, descricao = ?, fk_categoria_id = ?, preco = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssidii", $this->nome, $this->descricao, $this->fk_categoria_id, $this->preco, $this->status, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
