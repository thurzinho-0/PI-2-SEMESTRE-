<?php
require_once("sessao_cliente.php");
require_once('../classes/Database.php');
require_once('../classes/Produto.php');

if (!isset($_GET['id'])) {
  header("Location: home.php");
  exit();
}

$id_produto = $_GET['id'];

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);
$produto->id = $id_produto;

$detalhes = $produto->buscaID();

if (!$detalhes) {
  echo "Produto não encontrado.";
  exit();
}

$lista_imagens = $produto->listarImagens();
$imagens = [];
while ($img = $lista_imagens->fetch_assoc()) {
  $imagens[] = $img['caminho'];
}

$lista_variacoes = $produto->listarVariacoes();
$cores_unicas = [];
$tamanhos_unicos = [];

while ($var = $lista_variacoes->fetch_assoc()) {
  if (!isset($cores_unicas[$var['fk_cor_id']])) {
    $cores_unicas[$var['fk_cor_id']] = [
      'id' => $var['fk_cor_id'],
      'nome' => $var['nome_cor']
    ];
  }
  if (!isset($tamanhos_unicos[$var['fk_tamanho_id']])) {
    $tamanhos_unicos[$var['fk_tamanho_id']] = [
      'id' => $var['fk_tamanho_id'],
      'nome' => $var['nome_tamanho']
    ];
  }
}

$imagem_principal = !empty($detalhes['imagem']) ? "../assets/uploads/" . $detalhes['imagem'] : "../assets/imagens/sem_foto.png";
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($detalhes['nome']) ?> — Cx Store</title>
  <link rel="stylesheet" href="../assets/css/details.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

  <header class="site-header">
    <div class="container header-inner">
      <div class="logo-container">
        <a href="home.php"><img src="../assets/imagens/Logo.jpg" alt="Logo Cx Store" class="logo"></a>
      </div>
      <nav class="nav-bar">
        <ul class="main-nav">
          <li><a href="home.php">Voltar para Loja</a></li>
          <li><a href="minhas_compras.php">Meus Pedidos</a></li>
        </ul>
      </nav>
      <div class="header-actions">
        <a href="carrinho.php" class="action-icon cart-icon">
          <i class="fas fa-shopping-bag"></i>
          <span class="cart-count">0</span>
        </a>
      </div>
    </div>
  </header>

  <main class="product-page container">

    <div class="breadcrumbs">
      <a href="home.php">Home</a>
      <span class="sep">/</span>
      <span><?= htmlspecialchars($detalhes['nome_categoria']) ?></span>
      <span class="sep">/</span>
      <span><?= htmlspecialchars($detalhes['nome']) ?></span>
    </div>

    <div class="product-detail">

      <aside class="gallery-col">
        <div class="main-image" id="mainImageWrap">
          <img id="mainImage" src="<?= $imagem_principal ?>" alt="<?= htmlspecialchars($detalhes['nome']) ?>">
        </div>
        <?php if (count($imagens) > 0): ?>
          <div class="thumbnails" style="display:flex; gap:10px; margin-top:10px; overflow-x:auto;">
            <img src="<?= $imagem_principal ?>" onclick="document.getElementById('mainImage').src=this.src" style="width:60px; height:60px; cursor:pointer; border:1px solid #ddd; object-fit:cover;">

            <?php foreach ($imagens as $img_extra): ?>
              <img src="../assets/uploads/<?= $img_extra ?>" onclick="document.getElementById('mainImage').src=this.src" style="width:60px; height:60px; cursor:pointer; border:1px solid #ddd; object-fit:cover;">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </aside>

      <section class="info-col">

        <h1 class="product-title" data-product-id="<?= $detalhes['id'] ?>"><?= htmlspecialchars($detalhes['nome']) ?></h1>

        <div class="meta">
          <div class="rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <div class="sku">Categoria: <strong><?= htmlspecialchars($detalhes['nome_categoria']) ?></strong></div>
        </div>

        <p class="short-desc">
          <?= nl2br(htmlspecialchars($detalhes['descricao'])) ?>
        </p>

        <div class="prices">
          <span class="price-current">R$ <?= number_format($detalhes['preco'], 2, ',', '.') ?></span>
        </div>

        <form id="productForm" class="purchase-form" onsubmit="return false;">

          <div class="field">
            <label>Tamanho</label>
            <div class="sizes" role="radiogroup">
              <?php if (empty($tamanhos_unicos)): ?>
                <span style="color:red;">Esgotado</span>
              <?php else: ?>
                <?php foreach ($tamanhos_unicos as $tam): ?>
                  <button type="button" class="size-btn" data-size="<?= $tam['nome'] ?>"><?= $tam['nome'] ?></button>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <p id="estoqueMessage" class="stock-info" style="margin-top:5px; font-weight:bold; height:20px;"></p>
          </div>

          <div class="field">
            <label>Cor</label>
            <div class="colors" role="radiogroup">
              <?php if (!empty($cores_unicas)): ?>
                <?php foreach ($cores_unicas as $cor): ?>
                  <button type="button" class="color-swatch"
                    data-color="<?= $cor['nome'] ?>"
                    data-cor-id="<?= $cor['id'] ?>">
                    <?= htmlspecialchars($cor['nome']) ?>
                  </button>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="field qty-field">
            <label>Quantidade</label>
            <div class="qty-controls">
              <button type="button" id="qtyMinus">-</button>
              <input type="number" id="qtyInput" value="1" min="1" />
              <button type="button" id="qtyPlus">+</button>
            </div>
          </div>

          <div class="actions">
            <button id="addToCart" class="btn add" disabled style="opacity: 0.5;">
              ADICIONAR À SACOLA <i class="fas fa-shopping-bag"></i>
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>

  <footer class="site-footer">
    <div class="container" style="text-align: center;">
      <p>© 2025 Cx Store. Todos os direitos reservados.</p>
    </div>
  </footer>

  <script src="../assets/js/details.js"></script>
  <script src="../assets/js/home.js"></script>
</body>

</html>
