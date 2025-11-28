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
    public $imagem;
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

        $query = "INSERT INTO " . $this->tabela_produto . " (nome, descricao, fk_categoria_id, preco, imagem) VALUES (?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $stmt->bind_param("ssids", $this->nome, $this->descricao, $this->fk_categoria_id, $this->preco, $this->imagem);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Metodo de listagem de produto
    public function listarTodos()
    {
        $query = "SELECT p.*, c.nome AS nome_categoria FROM " . $this->tabela_produto . " p LEFT JOIN categoria c ON p.fk_categoria_id = c.id ORDER BY p.nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    //Metodo de listagem de itens disponiveis
    public function listarDisponiveis()
    {
        $query = "SELECT p.*, c.nome AS nome_categoria FROM " . $this->tabela_produto . " p LEFT JOIN categoria c ON p.fk_categoria_id = c.id WHERE p.status = 1 AND p.ativo = 1 ORDER BY p.nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
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
        $query = "SELECT p.*, c.nome as nome_categoria FROM " . $this->tabela_produto . " p LEFT JOIN categoria c ON p.fk_categoria_id = c.id WHERE p.id = ? LIMIT 1";
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

    //Metodo de atualização de imagem principal
    public function atualizarImagem($novo_caminho)
    {
        $query_old = "SELECT imagem FROM " . $this->tabela_produto . " WHERE id = ? LIMIT 1";
        $stmt_old = $this->conn->prepare($query_old);
        $stmt_old->bind_param("i", $this->id);
        $stmt_old->execute();
        $res_old = $stmt_old->get_result();
        $old_image = ($res_old->num_rows == 1) ? $res_old->fetch_assoc()['imagem'] : null;

        $query = "UPDATE " . $this->tabela_produto . " SET imagem = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $novo_caminho, $this->id);

        if ($stmt->execute()) {
            return $old_image;
        }
        return false;
    }

    //Metodo de edição de status de anuncio através do toggler
    public function editarStatus()
    {
        $query = "UPDATE " . $this->tabela_produto . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->status, $this->id);
        return $stmt->execute();
    }


    //Metodo de verificacao de produto em pedidos
    public function produtoEmUso()
    {
        $query = "SELECT COUNT(pi.id) as total_uso FROM pedido_item pi JOIN variacao_produto vp ON pi.fk_variacao_produto_id = vp.id WHERE vp.fk_produto_anuncio_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        return $resultado['total_uso'] > 0;
    }

    //Metodo de inativar produto já comprado
    public function inativar()
    {
        $query = "UPDATE " . $this->tabela_produto . " SET status = '0' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Metodo de listagem de variações
    public function listarVariacoes()
    {
        $query = "SELECT v.id as id_variacao, c.nome as nome_cor, t.nome as nome_tamanho FROM variacao_produto v LEFT JOIN cor c ON v.fk_cor_id = c.id LEFT JOIN tamanho t ON v.fk_tamanho_id = t.id WHERE v.fk_produto_anuncio_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    //Metodo de adição de variação
    public function adicionarVariacao($id_cor, $id_tamanho)
    {
        if ($this->verificaVariacao($id_cor, $id_tamanho)) {
            return false;
        }
        $query = "INSERT INTO variacao_produto (fk_produto_anuncio_id, fk_cor_id, fk_tamanho_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("iii", $this->id, $id_cor, $id_tamanho);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de verificação de variação existente
    public function verificaVariacao($id_cor, $id_tamanho)
    {
        $query = "SELECT * FROM variacao_produto WHERE fk_produto_anuncio_id = ? AND fk_cor_id = ? AND fk_tamanho_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $this->id, $id_cor, $id_tamanho);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    //Metodo de exclusão de variação
    public function excluirVariacao($id)
    {
        $query = "DELETE FROM variacao_produto WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de adição de imagem secundária
    public function adicionarImagemSecundaria($caminho_imagem)
    {
        $query = "INSERT INTO imagem_produto (caminho, fk_produto_anuncio) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("si", $caminho_imagem, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de listagem de imagens
    public function listarImagens()
    {
        $query = "SELECT id, caminho FROM imagem_produto WHERE fk_produto_anuncio = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado;
    }

    //Metodo de exclusão de imagem
    public function excluirImagem($id_imagem)
    {
        $query = "DELETE FROM imagem_produto WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_imagem);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de busca de imagem
    public function buscaImagem($id_imagem)
    {
        $query = "SELECT caminho FROM imagem_produto WHERE id = ? AND fk_produto_anuncio = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_imagem, $this->id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            return $row['caminho'];
        }
        return false;
    }
}
