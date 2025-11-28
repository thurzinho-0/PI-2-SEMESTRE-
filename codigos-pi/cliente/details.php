<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cx Store — Detalhes do Produto</title>
  <!-- CSS customizado da página de detalhes -->
  <link rel="stylesheet" href="details.css" />
  <!-- Biblioteca de ícones Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>

  <!-- ======================= CABEÇALHO ======================= -->
  <header class="site-header">
    <div class="container header-inner">
      
      <!-- Logo da loja -->
      <div class="logo-container">
        <a href="home.html">
          <img src="Logo.jpg" alt="Logo Cx Store" class="logo">
        </a>
      </div>

      <!-- Menu de navegação -->
      <nav class="nav-bar">
        <ul class="main-nav">
          <li><a href="home.html#novidades">Novidades</a></li>
          <li><a href="home.html#camisetas">Camisetas</a></li>
          <li><a href="home.html#calcas">Calças</a></li>
          <li><a href="home.html#sale" class="sale-link">Promoções</a></li>
        </ul>
      </nav>

      <!-- Ações do header: perfil e carrinho -->
      <div class="header-actions">
        <a href="#" class="action-icon" aria-label="Acessar perfil">
          <i class="fas fa-user"></i>
        </a>
        <a href="#" class="action-icon cart-icon" aria-label="Carrinho">
          <i class="fas fa-shopping-bag"></i>
          <span class="cart-count">0</span>
        </a>
      </div>
    </div>
  </header>

  <!-- ======================= CONTEÚDO PRINCIPAL ======================= -->
  <main class="product-page container">
    
    <!-- Breadcrumbs / Caminho de navegação -->
    <div class="breadcrumbs">
      <a href="home.html">Home</a> 
      <span class="sep">/</span>
      <a href="home.html#camisetas">Camisetas</a> 
      <span class="sep">/</span>
      <span>Camiseta Streetwear Cristal Ball Black</span>
    </div>

    <!-- Layout de 2 colunas: imagem + informações -->
    <div class="product-detail">
      
      <!-- ========== COLUNA ESQUERDA: IMAGEM DO PRODUTO ========== -->
      <aside class="gallery-col">
        <div class="main-image" id="mainImageWrap">
          <!-- Imagem principal do produto -->
          <img id="mainImage" src="camiseta1.png" alt="Camiseta Streetwear Cristal Ball Black">
          
          <!-- Botão de favoritos (wishlist) -->
          <button class="wish-btn" aria-label="Adicionar aos favoritos">
            <i class="far fa-heart"></i>
          </button>
        </div>
      </aside>

      <!-- ========== COLUNA DIREITA: INFORMAÇÕES DO PRODUTO ========== -->
      <section class="info-col">
        
        <!-- Título do produto -->
        <h1 class="product-title" data-product-id="45">Camiseta Streetwear Cristal Ball Black</h1>

        <!-- Meta informações: avaliação e SKU -->
        <div class="meta">
          <!-- Avaliação com 5 estrelas cheias ⭐⭐⭐⭐⭐ -->
          <div class="rating" aria-label="Avaliação: 5 de 5 estrelas" title="5 de 5 estrelas">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <span class="reviews">(12 avaliações)</span>
          </div>
          <!-- SKU do produto -->
          <div class="sku">SKU: <strong>CR-3862</strong></div>
        </div>

        <!-- Descrição resumida do produto -->
        <p class="short-desc">
          Camiseta estampada em tecido 100% algodão. Corte oversized, acabamento premium e estampa exclusiva Chronic.
        </p>

        <!-- Preços: antigo e atual -->
        <div class="prices">
          <span class="price-old">R$ 89,00</span>
          <span class="price-current">R$ 79,00</span>
        </div>
        <!-- Informação de parcelamento -->
        <div class="pay-info">ou 6x de R$ 13,83 sem juros</div>

        <!-- Promoção especial -->
        <p class="promo">Leve 3 e ganhe 5% OFF</p>

        <!-- ========== FORMULÁRIO DE COMPRA ========== -->
        <form id="productForm" class="purchase-form" onsubmit="return false;">
          
          <!-- Seleção de tamanho -->
          <div class="field">
            <label>Tamanho</label>
            <div class="sizes" role="radiogroup" aria-label="Selecionar tamanho">
              <button type="button" class="size-btn" data-size="P">P</button>
              <button type="button" class="size-btn" data-size="M">M</button>
              <button type="button" class="size-btn" data-size="G">G</button>
              <button type="button" class="size-btn" data-size="GG">GG</button>
            </div>
            <p id="estoqueMessage" class="stock-info"></p>
          </div>

          <!-- Seleção de cor -->
          <div class="field">
            <label>Cor</label>
            <div class="colors" role="radiogroup" aria-label="Selecionar cor">
              <button type="button" class="color-swatch" data-color="preto" data-cor-id="7" title="Preto" style="background:#111;"></button>
              <button type="button" class="color-swatch" data-color="branco" data-cor-id="6" title="Branco" style="background:#fff; border:1px solid #ddd;"></button>
            </div>
          </div>

          <!-- Seleção de quantidade -->
          <div class="field qty-field">
            <label>Quantidade</label>
            <div class="qty-controls">
              <button type="button" id="qtyMinus" aria-label="Diminuir quantidade">-</button>
              <input type="number" id="qtyInput" value="1" min="1" />
              <button type="button" id="qtyPlus" aria-label="Aumentar quantidade">+</button>
            </div>
          </div>

          <!-- Botões de ação -->
          <div class="actions">
            <button id="addToCart" class="btn add">
              ADICIONAR À SACOLA <i class="fas fa-shopping-bag"></i>
            </button>
            <button id="consultBtn" class="btn consult">
              CONSULTAR
            </button>
          </div>

          <!-- Informações extras: frete e troca -->
          <div class="extra-info">
            <p><i class="fas fa-sync-alt"></i> Troca em até 7 dias</p>
          </div>
        </form>
      </section>
    </div>
  </main>

  <!-- ======================= RODAPÉ ======================= -->
  <footer class="site-footer">
    <div class="container footer-inner">
      
      <!-- Coluna: Sobre -->
      <div>
        <h4>Sobre a Cx Store</h4>
        <p>Streetwear autêntico para quem vive a cultura urbana.</p>
      </div>

      <!-- Coluna: Contato -->
      <div>
        <h4>Contato</h4>
        <ul>
          <li><i class="fas fa-envelope"></i> caiobethegueli@gmail.com</li>
          <li><i class="fas fa-phone"></i> (19) 97133-8665</li>
          <li><i class="fas fa-map-marker-alt"></i> São Paulo, SP</li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- Script JavaScript de interações -->
  <script src="details.js"></script>
</body>
</html>
