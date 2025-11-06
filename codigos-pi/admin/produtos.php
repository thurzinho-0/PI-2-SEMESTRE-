<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
require_once('../classes/Categoria.php');

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);
$categoria = new Categoria($db);

$lista_produtos = $produto->listarAtivos();
$lista_categoria = $categoria->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gerenciar Produtos - CX Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/produtos.css" />
</head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar ao Painel</a>
        <a href="add_produto.php" class="btn-sair">Adicionar Produto</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <?php include('../includes/mensagens.php'); ?>
    
    <h2>GERENCIAMENTO DE PRODUTOS</h2>

    <section class="lista-container">
        <h3>Produtos Cadastrados</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_produtos->num_rows == 0) {
                        echo '<tr>';
                        echo '<td colspan="7" class="empty-message">Nenhum produto cadastrado ainda.</td>';
                        echo '</tr>';
                    } else {
                        while ($linha = $lista_produtos->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
                            echo '<td>' . htmlspecialchars($linha['nome_categoria']) . '</td>';
                            echo '<td>' . (empty($linha['descricao']) ? 'Descrição não definida' : htmlspecialchars($linha['descricao'])) . '</td>';
                            echo '<td>' . (is_null($linha['preco']) ? 'Valor não definido' : 'R$ ' . number_format($linha['preco'], 2, ',', '.')) . '</td>';
                            echo '<td>' . htmlspecialchars($linha['status'] == 1 ? 'Ativo' : 'Inativo') . '</td>';
                            echo '<td>' .
                                (!empty($linha['imagem'])
                                    ? '<img src="../assets/uploads/' . htmlspecialchars($linha['imagem']) . '" alt="' . htmlspecialchars($linha['nome']) . '" class="img-produto">'
                                    : 'Sem imagem')
                                . '</td>';
                            echo '<td>';
                            echo '<a href="edit_produto.php?id=' . $linha['id'] . '" class="btn-acao editar">Editar</a> ';
                            echo '<a href="excluir_produto.php?id=' . $linha['id'] . '" class="btn-acao excluir">Excluir</a>';
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