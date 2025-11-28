<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new tamanho($db);

    $res = false;

    if (!empty($_GET['id'])) {
        $tamanho->id = $_GET['id'];
        $res = $tamanho->buscaID();

        if (!$res) {
            $_SESSION['msg_erro'] = $mensagens['tamanho_nao_existente'];
            header("Location: tamanho.php"); //tamanho não existente
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: tamanho.php"); //campo ID vazio
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar tamanho - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/tamanho.css" />
</head>

<body>
    <div class="top-nav">
        <a href="tamanho.php" class="btn-voltar">← Voltar para Tamanho</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>EDITAR tamanho</h2>

    <section class="form-container">
        <h3>Alterar Dados do tamanho</h3>

        <form action="processa_edit_tamanho.php" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($res['id']); ?>">

            <div class="form-group">
                <label for="nome">Tamanho:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($res['nome']); ?>" placeholder="Ex: Camisetas" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-adicionar">Salvar Alterações</button>
                <a href="tamanhos.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</body>

</html>