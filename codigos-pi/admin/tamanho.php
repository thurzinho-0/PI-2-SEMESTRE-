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

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="msg sucesso">
            <?php
            switch ($_GET['sucesso']) {
                case 1:
                    echo "Tamanho cadastrado com sucesso.";
                    break;
                case 2:
                    echo "Tamanho excluído com sucesso.";
                    break;
                case 3:
                    echo "Tamanho editado com sucesso.";
                    break;
                case 4:
                    echo "Tamanho inativado com sucesso.";
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
                    echo "Tamanho já existente.";
                    break;
                case 2:
                    echo "O campo nome não pode estar vazio.";
                    break;
                case 3:
                    echo "Método de requisição inválido.";
                    break;
                case 4:
                    echo "Tamanho não excluído.";
                    break;
                case 5:
                    echo "Campo ID vazio.";
                    break;
                case 6:
                    echo "Tamanho não editado.";
                    break;
                case 7:
                    echo "Campo ID ou Nome vazio.";
                    break;
                case 8:
                    echo "Tamanho não existente.";
                    break;
                case 9:
                    echo "Tamanho não inativado.";
                    break;
                default:
                    echo "Erro desconhecido.";
            }
            ?>
        </div>
    <?php endif; ?>

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