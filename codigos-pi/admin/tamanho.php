<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

$database = new Database();
$db = $database->getConnection();
$tamanho = new Tamanho($db);
$lista_tamanho = $tamanho->listarAtivo();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tamanho</title>
    <link rel="stylesheet" href="../assets/css/tamanho.css">
</head>

<body>
    <h1>Gerenciamento de Tamanho</h1>

    <?php include('../includes/mensagens.php'); ?>

    <form action="add_tamanho.php" method="POST">
        <label for="nome_tamanho">Tamanho:</label>
        <input type="text" id="nome_tamanho" name="nome" required>

        <button type="submit">Adicionar</button>
    </form>

    <h2>Tamanhos cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($lista_tamanho->num_rows == 0) {
                echo '<tr><td colspan="3">Nenhuma tamanho cadastrada.</td></tr>';
            } else {
                while ($linha = $lista_tamanho->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
                    echo '<td>Ativo</td>';
                    echo '<td>
                        <a href="edit_tamanho.php?id=' . $linha['id'] . '">Editar</a> |
                        <a href="excluir_tamanho.php?id=' . $linha['id'] . '">Excluir</a>
                    </td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <a href="tamanho_inativo.php">Ver tamanho inativos</a>
    <a href="controle.php">Voltar</a>

</body>

</html>