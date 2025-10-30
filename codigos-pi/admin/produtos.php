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

    <h2>GERENCIAMENTO DE PRODUTOS</h2>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="mensagem sucesso">
            <?php
            switch ($_GET['sucesso']) {
                case 1:
                    echo "Produto cadastrado com sucesso.";
                    break;
                case 2:
                    echo "Produto excluído com sucesso.";
                    break;
                case 3:
                    echo "Produto editado com sucesso.";
                    break;
                default:
                    echo "Operação realizada com sucesso.";
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="mensagem erro">
            <?php
            switch ($_GET['erro']) {
                case 1:
                    echo "Produto já existente.";
                    break;
                case 2:
                    echo "O campo nome não pode estar vazio.";
                    break;
                case 3:
                    echo "Método de requisição inválido.";
                    break;
                case 4:
                    echo "Produto não excluído.";
                    break;
                case 5:
                    echo "Campo ID vazio.";
                    break;
                case 6:
                    echo "Produto não editado.";
                    break;
                case 7:
                    echo "Campo ID ou Nome vazio.";
                    break;
                case 8:
                    echo "Produto não existente.";
                    break;
                case 9:
                    echo "Categoria não selecionada.";
                    break;
                default:
                    echo "Erro desconhecido.";
            }
            ?>
        </div>
    <?php endif; ?>

    <section class="form-container">
        <h3>Adicionar Novo Produto</h3>

        <form action="add_produto.php" method="POST">
            <div class="form-group">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome" placeholder="Ex: Sufgang" required>
            </div>

            <div class="form-group">
                <label for="categoria_produto">Categoria:</label>
                <select name="fk_categoria_id" id="categoria_produto" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    if ($lista_categoria->num_rows > 0) {
                        while ($cat = $lista_categoria->fetch_assoc()) {
                            echo '<option value="' . $cat['id'] . '">';
                            echo htmlspecialchars($cat['nome']);
                            echo '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Nenhuma categoria cadastrada</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nome_produto">Descrição do Produto (opcional):</label>
                <input type="text" id="nome_produto" name="descricao" placeholder="Ex: Tricot">
            </div>

            <div class="form-group">
                <label for="nome_produto">Preço do produto (apenas o número):</label>
                <input type="number" id="nome_produto" name="preco" placeholder="Ex: 40,00" required>
            </div>


            <button type="submit" class="btn-adicionar">Adicionar Produto</button>
        </form>
    </section>

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
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_produtos->num_rows == 0) {
                        echo '<tr>';
                        echo '<td colspan="6" class="empty-message">Nenhum produto cadastrado ainda.</td>';
                        echo '</tr>';
                    } else {
                        while ($linha = $lista_produtos->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
                            echo '<td>' . htmlspecialchars($linha['nome_categoria']) . '</td>';
                            echo '<td>' . (empty($linha['descricao']) ? 'Descrição não definida' : htmlspecialchars($linha['descricao'])) . '</td>';
                            echo '<td>' . (is_null($linha['preco']) ? 'Valor não definido' : 'R$ ' . number_format($linha['preco'], 2, ',', '.')) . '</td>';
                            echo '<td>' . htmlspecialchars($linha['status'] == 1 ? 'Ativo' : 'Inativo') . '</td>';
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