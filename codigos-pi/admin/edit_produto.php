<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
require_once('../classes/Categoria.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);
    $categoria = new Categoria($db);
    $res = false;

    $lista_categoria = $categoria->listar();

    if (!empty($_GET['id'])) {
        $produto->id = $_GET['id'];
        $res = $produto->buscaID();

        if (!$res) {
            $_SESSION['msg_erro'] = $mensagens['produto_nao_encontrado'];
            header("Location: produtos.php");
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: produtos.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/edit_produto.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="produtos.php" class="btn-voltar">← Voltar para Produtos</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <?php include('../includes/mensagens.php'); ?>

    <h2>EDITAR PRODUTO</h2>

    <section class="form-container">
        <h3>Alterar Dados do Produto</h3>

        <form action="processa_edit_produto.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= htmlspecialchars($res['id']) ?>">
            <input type="hidden" name="status" value="<?= htmlspecialchars($res['status']) ?>">

            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($res['nome']) ?>" placeholder="Ex: Camiseta Básica" required>
            </div>

            <div class="form-group">
                <label for="categoria_produto">Categoria:</label>
                <select name="fk_categoria_id" id="categoria_produto" required>
                    <?php
                    if ($lista_categoria->num_rows > 0) {
                        while ($cat = $lista_categoria->fetch_assoc()) {
                            $selected = ($cat['id'] == $res['fk_categoria_id']) ? 'selected' : '';
                            echo '<option value="' . $cat['id'] . '" ' . $selected . '>';
                            echo htmlspecialchars($cat['nome']);
                            echo '</option>';
                        }
                    } else {
                        echo '<option value="" disabled selected>Nenhuma categoria cadastrada</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição do Produto:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o produto..."><?= htmlspecialchars($res['descricao']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço do Produto (R$):</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?= number_format($res['preco'], 2, '.', '') ?>" placeholder="Ex: 49.90" required>
            </div>

            <div class="form-group">
                <label for="imagem_atual">Imagem Principal Atual:</label>
                <?php if (!empty($res['imagem'])): ?>
                    <img src="../assets/uploads/<?= htmlspecialchars($res['imagem']) ?>" alt="Imagem atual do produto" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">

                    <input type="hidden" name="imagem_existente" value="<?= htmlspecialchars($res['imagem']) ?>">
                <?php else: ?>
                    <p>Nenhuma imagem principal cadastrada.</p>
                    <input type="hidden" name="imagem_existente" value="">
                <?php endif; ?>

                <label for="nova_imagem">Substituir Imagem:</label>
                <input type="file" id="nova_imagem" name="nova_imagem" accept="image/*">
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-adicionar">Salvar Alterações</button>
                <a href="produtos.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</body>

</html>