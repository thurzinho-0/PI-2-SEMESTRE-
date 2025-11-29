<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Pedido.php');

$database = new Database();
$db = $database->getConnection();
$pedido = new Pedido($db);

$faturamento_total = $pedido->getTotalVendido();
$status_counts = $pedido->getContagemStatus();
$total_pedidos = array_sum($status_counts);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatórios - CX Store</title>
    <link rel="stylesheet" href="../assets/css/painel_admin.css" />
    <link rel="stylesheet" href="../assets/css/relatorios.css" />
</head>
<body>

    <header><img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" /></header>

    <div class="top-nav">
        <a href="controle.php" class="btn-voltar">← Voltar ao Painel</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>RELATÓRIO DE VENDAS</h2>

    <section class="lista-container">
        <h3>Resumo Financeiro</h3>
        <div class="relatorio-grid">
            <div class="card-relatorio card-money">
                <h3>Faturamento Total</h3>
                <p>R$ <?= number_format($faturamento_total, 2, ',', '.') ?></p>
            </div>
            
            <div class="card-relatorio card-total">
                <h3>Total de Pedidos</h3>
                <p><?= $total_pedidos ?></p>
            </div>
        </div>
    </section>

    <section class="lista-container">
        <h3>Status dos Pedidos</h3>
        <div class="relatorio-grid">
            <div class="card-relatorio card-pendente">
                <h3>Pendentes (Aguardando)</h3>
                <p><?= $status_counts['pendente'] ?></p>
            </div>

            <div class="card-relatorio card-aprovado">
                <h3>Aprovados (Vendas Reais)</h3>
                <p><?= $status_counts['aprovado'] ?></p>
            </div>

            <div class="card-relatorio card-rejeitado">
                <h3>Rejeitados / Cancelados</h3>
                <p><?= $status_counts['rejeitado'] ?></p>
            </div>
        </div>
    </section>

</body>
</html>
