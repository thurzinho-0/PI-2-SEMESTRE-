<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');

$database = new Database();
$db = $database->getConnection();
$cor = new Cor($db);
$lista_cores = $cor->listarInativo();
$ativo = 1;
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

    <h2>Cores inativadas</h2>
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
    <a href="cores_inativas.php">Ver cores inativas</a>
    <a href="controle.php">Voltar</a>

</body>

</html>