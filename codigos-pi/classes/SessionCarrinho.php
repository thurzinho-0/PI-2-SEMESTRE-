<?php
    session_start();

    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {


    $_SESSION['carrinho'] = [
        101 => [
            'nome' => 'Camiseta estampa "Eu não quero buxixo"',
            'preco' => 89.90,
            'qtd' => 1,
            'img' => './assets/camiseta2.png'
        ],

        102 => [
            'nome' => 'Camiseta estampa "HIGH"',
            'preco' => 89.90,
            'qtd' => 1,
            'img' => './assets/camiseta4.png'
        ]
    ];
    $_SESSION['carrinho_iniciado'] = true;
}

    $subtotal = 0;
?>