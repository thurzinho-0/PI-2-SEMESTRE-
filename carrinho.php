<?php

    require_once './php/SessionCarrinho.php';

    $subtotal = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/carrinho.css">
    <title>Carrinho de Compras - CX Store</title>
</head>
<body>
    <header>
        <img id="logo" src="./assets/logo.png" alt="">
    </header>
    <main>
        <section id="lista_produtos_carrinho">
            <h3>Meu carrinho</h3>
            <hr>
            <?php
                if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])):

                foreach ($_SESSION['carrinho'] as $id_produto => $item) :
                    $subtotal += $item['preco'] * $item['qtd'];
            ?>

            <div class="item-carrinho" data-preco="<?php echo $item['preco']; ?>">
                <img src="<?php echo $item['img'];?>" alt="<?php echo $item['nome'];?>" class="item-img">
                <div class="item-info">
                    <p class="item-nome"><?php echo $item['nome'];?></p>
                    <p class="item-preco">R$ <?php echo number_format($item['preco'], 2, ',', '.');?></p>
                </div>
                <div class="item-qtd">
                    <input type="number" class="input-qtd" value="<?php echo $item['qtd'];?>" min="1">
                </div>
                <div class="item-remover">
                    <a href="./php/Remover.php?id=<?php echo $id_produto;?>" class="btn-remover">
                        Remover
                    </a>
                </div>
            </div>
            <hr>
            <?php 
                endforeach;
            else:
                echo "<p>Seu carrinho está vazio.</p>";
            endif;
            ?>
        </section>
        <section id="resumo_compra">
            <h4>Resumo da compra</h4>
            <hr>
            <div class="linha-resumo">
                <p>Subtotal</p>
                <strong id="subtotal_valor">R$ <?php echo number_format($subtotal, 2, ',', '.');?></strong>
            </div>
            <div class="linha-resumo">
                <label for="">Cupom</label>
                <input type="text">
            </div>
            <div class="linha-resumo">
                <label>Frete</label>
                <input name="CEP" id="CEP" required pattern="\d{5}-\d{3}"/>
            </div>
            <div class="linha-resumo">
                <p>Total</p>
                <strong id="total_valor">R$ <?php echo number_format($subtotal, 2, ',', '.');?></strong>
            </div>
            <div class="botoes-container">
                <button class="btn finalizar">Finalizar compra</button>
                <button class="btn continuar">Continuar comprando</button>
            </div>
        </section>
    </main>
    <footer></footer>
    <script src="js/script.js"></script>
</body>
</html>