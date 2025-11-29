<?php
require_once('sessao_admin.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel de Controle - Cx Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/controle.css" />
</head>

<body>

    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-icons">
    </div>

    <div class="logout-btn">
        <a href="../logout.php" class="button-link">Sair</a>
    </div>


    <h2>PAINEL DE CONTROLE</h2>
    
    <?php include('../includes/mensagens.php'); ?>

    <section class="dashboard-panel">
        <a href="gerenciar_pedidos.php" class="card-link">
            <div class="card">
                <h3>Vendas / Aprovações</h3>
            </div>
        </a>

        <a href="categorias.php" class="card-link">
            <div class="card">
                <h3>Categorias</h3>
            </div>
        </a>

        <a href="cor.php" class="card-link">
            <div class="card">
                <h3>Cores</h3>
            </div>
        </a>

        <a href="tamanho.php" class="card-link">
            <div class="card">
                <h3>Tamanhos</h3>
            </div>
        </a>

        <a href="produtos.php" class="card-link">
            <div class="card">
                <h3>Produtos</h3>
            </div>
        </a>

        <a href="gerenciar_clientes.php" class="card-link">
            <div class="card">
                <h3>Clientes</h3>
            </div>
        </a>

        <a href="relatorios.php" class="card-link">
            <div class="card">
                <h3>Relatórios</h3>
            </div>
        </a>
    </section>

</body>

</html>