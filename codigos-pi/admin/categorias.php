<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');

$database = new Database();
$db = $database->getConnection();
$categoria = new Categoria($db);

$lista_categorias = $categoria->listar();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gerenciar Categorias - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/categorias.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar ao Painel</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAMENTO DE CATEGORIAS</h2>

    <?php include('../includes/mensagens.php'); ?>

    <section class="form-container">
        <h3>Adicionar Nova Categoria</h3>

        <form action="add_categoria.php" method="POST">
            <div class="form-group">
                <label for="nome_categoria">Nome da Categoria:</label>
                <input type="text" id="nome_categoria" name="nome" placeholder="Ex: Camisetas" required>
            </div>
            <button type="submit" class="btn-adicionar">Adicionar Categoria</button>
        </form>
    </section>

    <section class="lista-container">
        <h3>Categorias Cadastradas</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_categorias->num_rows == 0) {
                        echo '<tr>';
                        echo '<td colspan="2" class="empty-message">Nenhuma categoria cadastrada ainda.</td>';
                        echo '</tr>';
                    } else {
                        while ($linha = $lista_categorias->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
                            echo '<td>';
                            echo '<a href="edit_categoria.php?id=' . $linha['id'] . '" class="btn-acao editar">Editar</a> ';
                            echo '<a href="excluir_categoria.php?id=' . $linha['id'] . '" class="btn-acao excluir">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </section>

</body>

</html>