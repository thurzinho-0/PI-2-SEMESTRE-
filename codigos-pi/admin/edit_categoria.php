<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    $res = false;

    if (!empty($_GET['id'])) {
        $categoria->id = $_GET['id'];
        $res = $categoria->buscaID();

        if (!$res) {
            $_SESSION['msg_erro'] = $mensagens['categoria_nao_existente'];
            header("Location: categorias.php");
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: categorias.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/categorias.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="categorias.php" class="btn-voltar">← Voltar para Categorias</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>EDITAR CATEGORIA</h2>

    <section class="form-container">
        <h3>Alterar Dados da Categoria</h3>

        <form action="processa_edit_categoria.php" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($res['id']); ?>">

            <div class="form-group">
                <label for="nome">Nome da Categoria:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($res['nome']); ?>" placeholder="Ex: Camisetas" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-adicionar">Salvar Alterações</button>
                <a href="categorias.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</body>

</html>