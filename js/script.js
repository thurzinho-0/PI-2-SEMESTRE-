document.addEventListener("DOMContentLoaded", () => {
    function atualizaTotal() {
        let novoSubtotal = 0;

        const todosItens = document.querySelectorAll('.item-carrinho');

        todosItens.forEach(item => {
            const preco = parseFloat(item.dataset.preco);
            const quantidade = parseInt(item.querySelector(".input-qtd").value);

            novoSubtotal += preco * quantidade;
        });

        const subFormatado = "R$ " + novoSubtotal.toFixed(2).replace('.', ',');

        const subTotalElemento = document.getElementById("subtotal_valor");
        const totalElemento = document.getElementById("total_valor");

        subTotalElemento.innerText = subFormatado;
        totalElemento.innerText = subFormatado;
    }

    const inputsQtd = document.querySelectorAll(".input-qtd");

    inputsQtd.forEach(input => {
        input.addEventListener("input", atualizaTotal);
    });
});