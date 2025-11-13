<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
require_once('../classes/Categoria.php');

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);
$categoria = new Categoria($db);

$lista_produtos = $produto->listarTodos();
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
                        echo '<tr><td colspan="7" class="empty-message">Nenhum produto cadastrado ainda.</td></tr>';
                    } else {
                        while ($linha = $lista_produtos->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['nome_categoria']) . "</td>";
                            echo "<td>" . (empty($linha['descricao']) ?
                                'Descrição não definida' : htmlspecialchars($linha['descricao'])) . "</td>";
                            echo "<td>" . (is_null($linha['preco']) ?
                                'Valor não definido' : 'R$ ' . number_format($linha['preco'], 2, ',', '.')) . "</td>";
                            echo "<td>
                                    <label class='switch'>
                                        <input type='checkbox' class='toggle-status' data-id='{$linha['id']}' " .
                                ($linha['status'] ? 'checked' : '') . ">
                                        <span class='slider round'></span>
                                    </label>
                                </td>";
                            echo "<td>";
                            if (!empty($linha['imagem'])) {
                                echo "<img src='../assets/uploads/" . htmlspecialchars($linha['imagem']) . "' 
                                      alt='" . htmlspecialchars($linha['nome']) . "' class='img-produto'>";
                            } else {
                                echo "Sem imagem";
                            }
                            echo "</td>";
                            echo "<td>
                                    <a href='gerenciar_variacoes.php?id_produto={$linha['id']}' class='btn-acao editar'>Variações</a>
                                    <a href='edit_produto.php?id={$linha['id']}' class='btn-acao editar'>Editar</a>
                                    <a href='excluir_produto.php?id={$linha['id']}' class='btn-acao excluir'>Excluir</a>
                                  </td>";

                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>

    </section>

    <script>
        document.querySelectorAll('.toggle-status').forEach(el => {
            el.addEventListener('change', () => {
                const id = el.dataset.id;
                const status = el.checked ? 1 : 0;

                fetch('toggle_anuncio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&status=${status}`
                });
            });
        });
    </script>

</body>

</html>