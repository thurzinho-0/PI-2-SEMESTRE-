<?php
require_once('sessao_cliente.php');
require_once('../classes/Database.php');
require_once('../classes/Pedido.php');

$database = new Database();
$db = $database->getConnection();
$pedido = new Pedido($db);

$lista_pedidos = $pedido->listarPorUsuario($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras - CX Store</title>

    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/minhas_compras.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

    <header class="site-header">
        <div class="container">
            <div class="logo-container">
                <a href="home.php"><img src="../assets/imagens/Logo.jpg" alt="Logo Cx Store"></a>
            </div>
            <nav class="nav-bar">
                <div class="main-nav">
                    <a href="home.php">Voltar à Loja</a>
                    <a href="../logout.php">Sair</a>
                </div>
            </nav>
        </div>
    </header>

    <div class="container-pedidos">
        <h2>Minhas Compras</h2>

        <?php if ($lista_pedidos->num_rows == 0): ?>
            <div class="sem-pedidos">
                <i class="fas fa-shopping-bag"></i>
                <p>Você ainda não fez nenhuma compra.</p>
                <a href="home.php">Ir para a loja</a>
            </div>
        <?php else: ?>
            <?php while ($item = $lista_pedidos->fetch_assoc()): ?>
                <div class="card-pedido">
                    <div class="pedido-info">
                        <h3>Pedido #<?= $item['id'] ?></h3>
                        <span class="pedido-data">
                            <i class="far fa-calendar-alt"></i>
                            <?= date('d/m/Y \à\s H:i', strtotime($item['data_criacao'])) ?>
                        </span>
                    </div>

                    <div class="pedido-total">
                        <span>Total</span>
                        <strong>R$ <?= number_format($item['total'], 2, ',', '.') ?></strong>
                    </div>

                    <div class="pedido-status">
                        <span class="status status-<?= $item['status'] ?>">
                            <?= ucfirst($item['status']) ?>
                        </span>
                    </div>

                    <div class="pedido-acao">
                        <?php if ($item['status'] == 'pendente'): ?>
                            <a href="https://wa.me/5519971338665?text=Olá, gostaria de falar sobre o pagamento do pedido #<?= $item['id'] ?>" target="_blank" class="btn-zap">
                                <i class="fab fa-whatsapp"></i> Falar com a Loja
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</body>

</html>