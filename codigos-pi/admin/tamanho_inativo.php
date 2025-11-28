<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

$database = new Database();
$db = $database->getConnection();
$tamanho = new Tamanho($db);
$lista_tamanho = $tamanho->listarInativo();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Tamanhos Inativos - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
</head>

<body>
    <header><img src="../assets/imagens/Logo.jpg" alt="Logo CX Store" /></header>

    <div class="top-nav">
        <a href="tamanho.php" class="btn-voltar">← Voltar</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>TAMANHOS INATIVADOS</h2>

    <section class="lista-container">
        <h3>Lista de Tamanhos Inativos</h3>
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
                            <td colspan="2" class="empty-message">Nenhum tamanho inativado.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($linha = $lista_tamanho->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($linha['nome']) ?></td>
                                <td class="acoes">
                                    <a href="processa_ativa_tamanho.php?id=<?= $linha['id'] ?>" class="btn-editar">Ativar</a>
                                    <a href="excluir_tamanho.php?id=<?= $linha['id'] ?>" class="btn-excluir">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>