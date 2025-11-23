<<<<<<< HEAD
 <?php 
  require_once ("sessao_cliente.php");
?>
=======
>>>>>>> origin/backend
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Cx Store Anúncios</title>
<link rel="stylesheet" href="../assets/css/painelanuncio.css" />
<!--
  Este código foi desenvolvido com base na análise visual da imagem enviada ('image.jpg')
  e também levando em conta boas práticas e inspirações encontradas em canais brasileiros de programação no YouTube,
  que produzem conteúdos didáticos sobre HTML, CSS e dashboards para web.

  Canais recomendados e usados como referência de aprendizado para este tipo de layout são:
  - Curso em Vídeo (Gustavo Guanabara): https://www.youtube.com/@CursoemVideo
  - Danki Code: https://www.youtube.com/@DankiCode
  - Programação Web: https://www.youtube.com/@programacaoweb
  - Filipe Deschamps: https://www.youtube.com/@FilipeDeschamps
  - Rafaella Ballerini: https://www.youtube.com/@rafaellaballerini

  As decisões de código, estrutura e estilo foram feitas pelo autor observando a imagem e utilizando conhecimentos adquiridos nesses canais.
-->
</head>

<body>

<!-- ==============================
     CABEÇALHO COM LOGO
     ============================== -->
<header>
<<<<<<< HEAD
  <img src="assets/css/painelanuncio.css" alt="Cx Store Logo" />
=======
  <img src="assets/css/painelanuncio.css" alt="Ex Store Logo" />
>>>>>>> origin/backend
</header>

<!-- ==============================
     ÍCONES FIXOS (Adicionar / Configurações / Usuário)
     ============================== -->
<div class="top-icons">
  <!-- Ícone de adicionar novo produto -->
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
  </svg>

  <!-- Ícone de configurações (ativo) -->
  <svg class="active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-10v2m4-2l1.5 1.5m-9 9L7.5 17.5m8.5-4.5l1.5-1.5m-9-9L7 7"/>
  </svg>

  <!-- Ícone de perfil do usuário -->
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 1 0-10 0 5 5 0 0 0 10 0zm0 1v7"/>
  </svg>
</div>

<!-- ==============================
     SEÇÃO DE ANÚNCIOS
     ============================== -->
<h2>ANÚNCIOS</h2>

<div class="table-container">
<table>
  <thead>
    <tr>
      <th>Nome do Produto</th>
      <th>Imagem</th>
      <th>Categoria</th>
      <th>Preço</th>
      <th>Data</th>
      <th>Ação</th>
      <th>Status</th>
    </tr>
  </thead>

  <tbody>
    <!-- Linha 1 -->
    <tr>
      <td>TRICOT SUFGANG YING YANG BLACK</td>
      <td><img class="product-img" src="exemplocamiseta1.JPG" alt="Tricot Ying Yang Black Masculino" /></td>
      <td>Masculino</td>
      <td class="price">R$50,00</td>
      <td class="date">09/10/2025</td>
      <td>
        <!-- Switch de status -->
        <label class="status-switch">
          <input type="checkbox" />
          <span class="slider"></span>
        </label>
        <!-- Ícone de edição -->
        <svg class="icon-edit" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h6M6 19h6m-4-7h8"/>
        </svg>
      </td>
      <td><span class="status-label inativo">Inativo</span></td>
    </tr>

    <!-- Linha 2 -->
    <tr>
      <td>TRICOT SUFGANG YING YANG BLACK</td>
      <td><img class="product-img" src="https://i.imgur.com/VdMRBzA.png" alt="Tricot Ying Yang Black Feminino" /></td>
      <td>Feminino</td>
      <td class="price">R$309,90</td>
      <td class="date">09/10/2025</td>
      <td>
        <label class="status-switch">
          <input type="checkbox" checked />
          <span class="slider"></span>
        </label>
        <svg class="icon-edit" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h6M6 19h6m-4-7h8"/>
        </svg>
      </td>
      <td><span class="status-label ativo">Ativo</span></td>
    </tr>
  </tbody>
</table>
</div>

<!-- ==============================
     SCRIPT PARA ATUALIZAR STATUS DINAMICAMENTE
     ============================== -->
<script>
  // Ao carregar a página
  document.addEventListener('DOMContentLoaded', function() {
    const switches = document.querySelectorAll('.status-switch input[type="checkbox"]');
    
    switches.forEach(function(switchEl, index) {
      const label = document.querySelectorAll('.status-label')[index];

      // Função que muda o texto conforme o estado do switch
      function updateLabel() {
        if (switchEl.checked) {
          label.textContent = 'Ativo';
          label.className = 'status-label ativo';
        } else {
          label.textContent = 'Inativo';
          label.className = 'status-label inativo';
        }
      }

      // Quando o usuário clica no botão
      switchEl.addEventListener('change', updateLabel);

      // Inicializa o estado ao abrir a página
      updateLabel();
    });
  });
</script>

</body>
</html>
