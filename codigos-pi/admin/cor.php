<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');

$database = new Database();
$db = $database->getConnection();
$cor = new Cor($db);
$lista_cores = $cor->listarAtivo();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Cores</title>
    <link rel="stylesheet" href="../assets/css/cor.css">
</head>

<body>
    <h1>Gerenciamento de Cores</h1>

    <?php include('../includes/mensagens.php'); ?>


    <form action="add_cor.php" method="POST">
        <label for="nome_cor">Nome da cor:</label>
        <input type="text" id="nome_cor" name="nome" required>

        <button type="submit">Adicionar</button>
    </form>

    <h2>Cores cadastradas</h2>
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
            if ($lista_cores->num_rows == 0) {
                echo '<tr><td colspan="3">Nenhuma cor cadastrada.</td></tr>';
            } else {
                while ($linha = $lista_cores->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
                    echo '<td>Ativo</td>';
                    echo '<td>
                        <a href="edit_cor.php?id=' . $linha['id'] . '">Editar</a> |
                        <a href="excluir_cor.php?id=' . $linha['id'] . '">Excluir</a>
                    </td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <a href="cor_inativa.php">Ver cores inativas</a>
    <a href="controle.php">Voltar</a>

</body>

</html>