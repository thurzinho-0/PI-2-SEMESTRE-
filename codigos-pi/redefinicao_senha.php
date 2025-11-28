<?php
 session_start();
 require_once './classes/Usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"> 
  <title>Redefinir Senha</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/redefinicaosenha.css">
</head>
<body>

  <div class="form">

    <div class="logo">
      <img src="assets/imagens/Logo.jpg" alt="Logo da Empresa">
    </div>

    <!-- FORMULÁRIO PHP/HTML -->
    <form action="processa_redefinicao.php" method="POST">

      <div class="flex-column">
        <label for="nova_senha">Nova Senha</label>
        <div class="inputForm">
          <input class="input" type="password" name="nova_senha" placeholder="Nova senha" required>
        </div>
      </div>

      <div class="flex-column">
        <label for="confirmar_senha">Confirmar Senha</label>
        <div class="inputForm">
          <input class="input" type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
        </div>
      </div>

      <button type="submit" class="button-submit">Salvar nova senha</button>

    </form>
    <!-- FIM DO FORMULÁRIO -->

    <p class="p"><a href="login.php">Voltar para o login</a></p>

  </div>

</body>
</html>
