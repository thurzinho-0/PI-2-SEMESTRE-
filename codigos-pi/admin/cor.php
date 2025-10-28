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

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="msg sucesso">
            <?php
            switch ($_GET['sucesso']) {
                case 1:
                    echo "Cor cadastrada com sucesso.";
                    break;
                case 2:
                    echo "Cor excluída com sucesso.";
                    break;
                case 3:
                    echo "Cor editada com sucesso.";
                    break;
                case 4:
                    echo "Cor inativada com sucesso.";
                    break;
                default:
                    echo "Operação realizada com sucesso.";
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="msg erro">
            <?php
            switch ($_GET['erro']) {
                case 1:
                    echo "Cor já existente.";
                    break;
                case 2:
                    echo "O campo nome não pode estar vazio.";
                    break;
                case 3:
                    echo "Método de requisição inválido.";
                    break;
                case 4:
                    echo "Cor não excluída.";
                    break;
                case 5:
                    echo "Campo ID vazio.";
                    break;
                case 6:
                    echo "Cor não editada.";
                    break;
                case 7:
                    echo "Campo ID ou Nome vazio.";
                    break;
                case 8:
                    echo "Cor não existente.";
                    break;
                case 9:
                    echo "Cor não inativada.";
                    break;
                default:
                    echo "Erro desconhecido.";
            }
            ?>
        </div>
    <?php endif; ?>

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