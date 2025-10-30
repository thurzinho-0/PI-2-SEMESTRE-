<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
require_once('../classes/Categoria.php');

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
            header("Location: produtos.php?erro=8");
            exit();
        }
    } else {
        header("Location: produtos.php?erro=5");
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
    <link rel="stylesheet" href="../assets/css/categorias.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="produtos.php" class="btn-voltar">← Voltar para Produtos</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>EDITAR PRODUTO</h2>

    <section class="form-container">
        <h3>Alterar Dados do Produto</h3>

        <form action="processa_edit_produto.php" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($res['id']); ?>">
            <input type="hidden" name="status" value="<?php echo htmlspecialchars($res['status']); ?>">


            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($res['nome']); ?>" placeholder="Ex: Camiseta Básica" required>
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
                <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o produto..." required><?php echo htmlspecialchars($res['descricao']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço do Produto (R$):</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?php echo number_format($res['preco'], 2, '.', ''); ?>" placeholder="Ex: 49.90" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-adicionar">Salvar Alterações</button>
                <a href="produtos.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</body>

</html>