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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gerenciar Categorias - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
</head>

<body>
    <header><img src="../assets/imagens/Logo.jpg" alt="Logo CX Store" /></header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar ao Painel</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAMENTO DE CATEGORIAS</h2>

    <?php include('../includes/mensagens.php'); ?>

    <section class="form-container" aria-labelledby="add-cat">
        <h3 id="add-cat">Adicionar Nova Categoria</h3>
        <form action="add_categoria.php" method="POST">
            <div class="form-group">
                <label for="nome_categoria">Nome da Categoria:</label>
                <input type="text" id="nome_categoria" name="nome" placeholder="Ex: Camisetas" required />
            </div>
            <button type="submit" class="btn-adicionar">Adicionar Categoria</button>
        </form>
    </section>

    <section class="lista-container" aria-labelledby="lista-cat">
        <h3 id="lista-cat">Categorias Cadastradas</h3>
        <div class="table-wrapper">
            <table role="table" aria-label="Tabela de categorias">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lista_categorias->num_rows == 0): ?>
                        <tr>
                            <td colspan="2" class="empty-message">Nenhuma categoria cadastrada ainda.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($linha = $lista_categorias->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($linha['nome']) ?></td>
                                <td class="acoes">
                                    <a href="edit_categoria.php?id=<?= $linha['id'] ?>" class="btn-editar">Editar</a>
                                    <a href="excluir_categoria.php?id=<?= $linha['id'] ?>" class="btn-excluir">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="small-actions">
            <a href="categoria_inativa.php" class="btn-voltar">Ver categorias inativas</a>
        </div>
    </section>
</body>

</html>