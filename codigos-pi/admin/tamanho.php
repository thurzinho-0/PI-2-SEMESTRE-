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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gerenciar Tamanhos - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
</head>

<body>
    <header><img src="../assets/imagens/Logo.jpg" alt="Logo CX Store" /></header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAMENTO DE TAMANHOS</h2>

    <?php include('../includes/mensagens.php'); ?>

    <section class="form-container">
        <h3>Adicionar Novo Tamanho</h3>
        <form action="add_tamanho.php" method="POST">
            <div class="form-group">
                <label for="nome_tamanho">Tamanho:</label>
                <input type="text" id="nome_tamanho" name="nome" required />
            </div>
            <button type="submit" class="btn-adicionar">Adicionar</button>
        </form>
    </section>

    <section class="lista-container">
        <h3>Tamanhos cadastrados</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lista_tamanho->num_rows == 0): ?>
                        <tr>
                            <td colspan="2" class="empty-message">Nenhum tamanho cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($linha = $lista_tamanho->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($linha['nome']) ?></td>
                                <td class="acoes"> 
                                    <a href="edit_tamanho.php?id=<?= $linha['id'] ?>" class="btn-editar">Editar</a>
                                    <a href="excluir_tamanho.php?id=<?= $linha['id'] ?>" class="btn-excluir">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="small-actions">
            <a href="tamanho_inativo.php" class="btn-voltar">Ver tamanhos inativos</a>
        </div>
    </section>
</body>

</html>