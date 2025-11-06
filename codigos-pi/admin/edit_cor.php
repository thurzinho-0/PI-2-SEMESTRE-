<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new cor($db);

    $res = false;

    if (!empty($_GET['id'])) {
        $cor->id = $_GET['id'];
        $res = $cor->buscaID();

        if (!$res) {
            $_SESSION['msg_erro'] = $mensagens['cor_nao_existente'];
            header("Location: cor.php");
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: cor.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cor - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/cor.css" />
</head>

<body>
    <div class="top-nav">
        <a href="cor.php" class="btn-voltar">← Voltar para Cor</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>EDITAR cor</h2>

    <section class="form-container">
        <h3>Alterar Dados da cor</h3>

        <form action="processa_edit_cor.php" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($res['id']); ?>">

            <div class="form-group">
                <label for="nome">Nome da cor:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($res['nome']); ?>" placeholder="Ex: Camisetas" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-adicionar">Salvar Alterações</button>
                <a href="cors.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</body>

</html>