<!-- Iniciando Sessão com PHP -->
<?php
session_start();
require_once './classes/Usuario.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Esqueci Minha Senha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- Link para o CSS externo -->
  <link rel="stylesheet" href="assets/css/esqueci_senha.css"> 
</head>
<body>
  <!-- Container centralizado para o formulário -->
  <div class="container">
    <!-- Logo -->
   <div class="logo">
    <img src="assets/imagens/Logo.jpg" alt="Logo da Empresa">
  </div>
    <h2>Esqueci minha senha</h2> 
    <p>Digite seu e-mail para recuperar sua senha:</p> 

    

    <!-- Formulário para envio do e-mail -->
    <form action="email_enviado.php" method="post">
      <input type="email" name="email" placeholder="Seu e-mail" required>
      <button type="submit">Enviar link</button>
    </form>
  </div>

</body>
</html>
