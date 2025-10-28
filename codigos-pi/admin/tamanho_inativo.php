<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

$database = new Database();
$db = $database->getConnection();
$tamanho = new Tamanho($db);
$lista_tamanho = $tamanho->listarInativo();
$ativo = 1;
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

    <h2>Tamanhos inativados</h2>
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
    <a href="tamanho_inativas.php">Ver tamanho inativas</a>
    <a href="controle.php">Voltar</a>

</body>

</html>