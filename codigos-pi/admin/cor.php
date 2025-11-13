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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gerenciar Cores - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
</head>

<body>
    <header><img src="../assets/imagens/Logo.jpg" alt="Logo CX Store" /></header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAMENTO DE CORES</h2>

    <?php include('../includes/mensagens.php'); ?>

    <section class="form-container">
        <h3>Adicionar Nova Cor</h3>
        <form action="add_cor.php" method="POST">
            <div class="form-group">
                <label for="nome_cor">Nome da cor:</label>
                <input type="text" id="nome_cor" name="nome" required />
            </div>
            <button type="submit" class="btn-adicionar">Adicionar</button>
        </form>
    </section>

    <section class="lista-container">
        <h3>Cores cadastradas</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lista_cores->num_rows == 0): ?>
                        <tr>
                            <td colspan="2" class="empty-message">Nenhuma cor cadastrada.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($linha = $lista_cores->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($linha['nome']) ?></td>
                                <td class="acoes">
                                    <a href="edit_cor.php?id=<?= $linha['id'] ?>" class="btn-editar">Editar</a>
                                    <a href="excluir_cor.php?id=<?= $linha['id'] ?>" class="btn-excluir">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="small-actions">
            <a href="cor_inativa.php" class="btn-voltar">Ver cores inativas</a>
        </div>
    </section>
</body>

</html>