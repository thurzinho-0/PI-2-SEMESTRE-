<!-- 
  Formulário de cadastro inspirado no canal Dev Club - Programação.
  Peguei essa ideia lá porque eles ensinam de um jeito bem didático a criar formulários modernos e responsivos. 
  Eu queria algo limpo, centralizado e fácil de usar, então adaptei o código para o que eu precisava.
-->

<!DOCTYPE html>
<html lang="PT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/cadastro.css">
</head>
<body>
  <form class="form" method="POST" action="processa_cadastro.php">
    <!-- Logo no topo para identidade visual -->
    <div class="logo">
      <img src="assets/imagens/Logo.jpg" alt="Logo">
    </div>

    <!-- Campo de telefone/contato -->
    <div class="flex-column"><label>Nome</label></div>
    <div class="inputForm">
      <svg height="20" viewBox="0 -9 32 32" width="20" xmlns="http://www.w3.org/2000/svg">
        <g id="Layer_3" data-name="Layer 3">
          <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"></path>
        </g>
      </svg>
      <input type="tel" class="input" placeholder="Digite seu nome" name="nome">
    </div>

    <!-- Campo de email -->
    <div class="flex-column"><label>Email</label></div>
    <div class="inputForm">
      <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg">
        <g id="Layer_3" data-name="Layer 3">
          <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
        </g>
      </svg>
      <input type="email" class="input" placeholder="Cadastre seu e-mail"  name="email"/>
    </div>

    <!-- Campo de senha -->
    <div class="flex-column"><label>Senha</label></div>
    <div class="inputForm">
      <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875 16-16 16zm0 0"></path>
        <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
      </svg>
      <input type="password" class="input" placeholder="Criar senha" name="senha"/>
    </div>

    <div class="flex-column"><label>Contato</label></div>
    <div class="inputForm">
      <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg">
        <g id="Layer_3" data-name="Layer 3">
          <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
        </g>
      </svg>
      <input type="text" class="input" name=""placeholder="Digite seu telefone" name="contato" />
    </div>

    <!-- Botão de cadastro -->
    <button class="button-submit">Cadastrar-se</button>

    <!-- Links úteis -->
    <p class="p">Já tem uma conta? <span class="span"><a href="login.php">Voltar<a></span></p>
  </form>
</body>
</html>
