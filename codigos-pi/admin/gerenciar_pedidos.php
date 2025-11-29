<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Pedido.php');

$database = new Database();
$db = $database->getConnection();
$pedido = new Pedido($db);

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $id_pedido = $_GET['id'];
    $novo_status = ($_GET['acao'] == 'aprovar') ? 'aprovado' : 'rejeitado';

    if ($pedido->atualizarStatus($novo_status, $id_pedido)) {
        $msg_sucesso = "Sucesso! O Pedido #$id_pedido foi marcado como " . strtoupper($novo_status) . ".";
    } else {
        $msg_erro = "Erro ao atualizar o pedido.";
    }
}

$lista = $pedido->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gerenciar Vendas - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
    <link rel="stylesheet" href="../assets/css/gerenciar_vendas.css" />
</head>

<body>
    <header><img src="../assets/imagens/Logo.jpg" alt="Logo CX Store" /></header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAMENTO DE VENDAS</h2>

    <?php if (isset($msg_sucesso)): ?>
        <div class="mensagem sucesso"><?= $msg_sucesso ?></div>
    <?php endif; ?>

    <section class="lista-container">
        <h3>Pedidos Realizados</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="acoes">Aprovação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lista->num_rows == 0): ?>
                        <tr>
                            <td colspan="6" class="empty-message">Nenhuma venda registrada.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($row = $lista->fetch_assoc()): ?>
                            <tr>
                                <td>#<?= $row['id'] ?></td>
                                <td>
                                    <?= htmlspecialchars($row['nome_cliente'] ?? 'Desconhecido') ?><br>
                                    <small><?= htmlspecialchars($row['email'] ?? '') ?></small>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['data_criacao'])) ?></td>
                                <td>R$ <?= number_format($row['total'], 2, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= $row['status'] ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                                <td class="acoes">
                                    <?php if ($row['status'] == 'pendente'): ?>
                                        <a href="?acao=aprovar&id=<?= $row['id'] ?>" class="btn-aprovar">✓ Aprovar</a>
                                        <a href="?acao=rejeitar&id=<?= $row['id'] ?>" class="btn-rejeitar">✕ Rejeitar</a>
                                    <?php else: ?>
                                        <span class="processado">Processado</span>
                                    <?php endif; ?>
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