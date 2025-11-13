<!-- Iniciando Sessão com PHP -->
<?php
session_start();
require_once './classes/Usuario.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Dados Pessoais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Link para o CSS externo -->
    <link rel="stylesheet" href="assets/css/editarcliente.css">
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
 
        <!-- Formulário de Dados Pessoais -->
        <form id="formPerfil" action="#" method="POST">
            <div class="form-group">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu Nome" required>
            </div>
 
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua Nova Senha" required>
            </div>
 
            <div class="form-group">
                <label for="confirmar">Confirmar Senha</label>
                <input type="password" id="confirmar" name="confirmar" placeholder="Confirme Sua Senha" required>
            </div>
 
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite Seu E-mail" required>
            </div>
 
            <div class="form-row">
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="Digite seu Número de Telefone">
                </div>
            </div>
 
            <!-- Endereço do Usuário -->
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" id="endereco" name="endereco" placeholder="Digite Seu Endereço ou Complemento" required>
            </div>
 
            <!-- Validação de CEP -->
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" placeholder="Digite o CEP, o Formato é 00000-0000" required>
                <p id="resultado"></p>
            </div>
 
            <!-- Ações -->
            <div class="actions">
                <button type="submit" class="btn btn-primary" id="btnSalvar">Salvar</button>
                <button type="reset" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
 
    <script>
        // Função de validação do CEP
        function validarCEP() {
            let cep = document.getElementById("cep").value;
            cep = cep.replace("-", "").trim();
            const resultado = document.getElementById("resultado");
 

            const regex = /^[0-9]{8}$/;
 
            if (regex.test(cep)) {
                resultado.style.color = "green";
                resultado.innerText = "CEP Válido!";
                return true;
            } else {
                resultado.style.color = "red";
                resultado.innerText = "CEP Inválido!";
                return false;
            }
        }
        document.getElementById("formPerfil").addEventListener("submit", function (event) {
         
            event.preventDefault();
 
            if (validarCEP()) {
               
                this.submit(); 
            } else {
                
                alert("Corrija os Dados Antes de Enviar.");
            }
        });
    </script>
</body>
</html>