<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');

$database = new Database();
$db = $database->getConnection();
$categoria = new Categoria($db);

$lista_categoria = $categoria->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adicionar Produto - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/add_produtos.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="produtos.php" class="btn-voltar">← Voltar aos Produtos</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>ADICIONAR PRODUTO</h2>

    <?php include('../includes/mensagens.php'); ?>

    <section class="form-container">
        <h3>Novo Produto</h3>

        <form action="processa_add_produto.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome" placeholder="Ex: Camiseta Básica" required>
            </div>

            <div class="form-group">
                <label for="categoria_produto">Categoria:</label>
                <select name="fk_categoria_id" id="categoria_produto" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    if ($lista_categoria->num_rows > 0) {
                        while ($cat = $lista_categoria->fetch_assoc()) {
                            echo '<option value="' . $cat['id'] . '">';
                            echo htmlspecialchars($cat['nome']);
                            echo '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Nenhuma categoria cadastrada</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição do Produto:</label>
                <textarea id="descricao" name="descricao" rows="6" placeholder="Descreva o produto..."></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço do Produto (R$):</label>
                <input type="number" step="0.01" id="preco" name="preco" placeholder="Ex: 49.90" required>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem Principal:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <button type="submit" class="btn-adicionar">Adicionar Produto</button>
        </form>
    </section>
</body>

</html>
