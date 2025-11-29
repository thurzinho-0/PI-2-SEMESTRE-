<?php
require_once("sessao_cliente.php");
require_once('../classes/Database.php');
require_once('../classes/Produto.php');

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

$lista_produtos = $produto->listarDisponiveis();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cx Store - Catálogo</title>
  <link rel="stylesheet" href="../assets/css/home.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

  <header class="site-header">
    <div class="container">
      <div class="logo-container">
        <a href="home.php"><img src="../assets/imagens/Logo.jpg" alt="Logo Cx Store"></a>
      </div>

      <nav class="nav-bar">
        <div class="main-nav">
          <ul>
            <li><a href="#catalogo">Catálogo</a></li>
            <li><a href="minhas_compras.php">Meus Pedidos</a></li>
          </ul>
        </div>

        <div class="header-actions">
          <a href="editardados.php" class="action-icon" title="Meu Perfil">
            <i class="fas fa-user"></i> <span style="font-size: 0.8rem;">Olá, <?php echo $_SESSION['usuario']; ?></span>
          </a>
          <a href="#" class="cart-icon action-icon" aria-label="Ver carrinho">
            <i class="fas fa-shopping-bag"></i>
            <span class="cart-count">0</span>
          </a>
          <a href="../logout.php" class="action-icon" title="Sair">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>

        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
      </nav>
    </div>
  </header>

  <section class="hero-banner">
    <div class="hero-content">
      <h1 class="hero-title">Nova Coleção</h1>
      <p class="hero-subtitle">Estilo autêntico. Qualidade incomparável.</p>
      <a href="#catalogo" class="hero-btn">Ver Produtos</a>
    </div>
    <div class="hero-overlay"></div>
  </section>

  <main>
    <section class="featured-products" id="catalogo">
      <div class="container">
        <div class="section-title">
          <span class="section-tag">Nosso Estoque</span>
          <h2>Catálogo Completo</h2>
          <p class="section-subtitle">Confira todas as peças disponíveis</p>
        </div>

        <div class="product-grid">
          <?php if ($lista_produtos->num_rows == 0): ?>
            <p style="grid-column: 1/-1; text-align: center;">Nenhum produto disponível no momento.</p>
          <?php else: ?>

            <?php while ($item = $lista_produtos->fetch_assoc()): ?>
              <?php
              $produto->id = $item['id'];
              $variacoes = $produto->listarVariacoes();
              $id_variacao_padrao = 0;

              if ($var = $variacoes->fetch_assoc()) {
                $id_variacao_padrao = $var['id_variacao'];
              }

              $imagem = !empty($item['imagem']) ? "../assets/uploads/" . $item['imagem'] : "../assets/imagens/sem_foto.png";
              ?>

              <article class="product-card" data-id="<?= $id_variacao_padrao ?>">
                <div class="product-image">
                  <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($item['nome']) ?>" />

                  <div class="product-overlay">
                    <a href="details.php?id=<?= $item['id'] ?>" class="quick-view-btn">
                      <i class="fas fa-eye"></i> Ver Detalhes
                    </a>
                  </div>
                </div>

                <div class="product-info">
                  <h3><?= htmlspecialchars($item['nome']) ?></h3>
                  <p style="font-size: 0.9rem; color: #666;"><?= htmlspecialchars($item['nome_categoria']) ?></p>
                  <p class="price">
                    <span class="price-current">R$ <?= number_format($item['preco'], 2, ',', '.') ?></span>
                  </p>
                </div>

                <?php if ($id_variacao_padrao > 0): ?>
                  <button class="add-to-cart-btn" data-id="<?= $id_variacao_padrao ?>">
                    <i class="fas fa-shopping-bag"></i> Adicionar ao Carrinho
                  </button>
                <?php else: ?>
                  <button class="add-to-cart-btn" disabled style="background: #ccc; cursor: not-allowed;">
                    Indisponível
                  </button>
                <?php endif; ?>

              </article>

            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-bottom" style="text-align: center; border: none;">
        <p>© 2025 Cx Store. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <button class="back-to-top"><i class="fas fa-chevron-up"></i></button>

  <script src="../assets/js/home.js"></script>
</body>

</html>
