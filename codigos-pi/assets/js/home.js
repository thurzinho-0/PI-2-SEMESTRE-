/**
 * =====================================================================
 * Cx Store - Script de Interatividade com Carrinho Otimizado
 * =====================================================================
 * 
 * Funcionalidades:
 * - Carrinho com persistência em localStorage
 * - Contador de carrinho com animações
 * - Exibição de itens do carrinho
 * - Feedback visual ao adicionar produtos
 * - Notificações de sucesso
 * - Botão de voltar ao topo
 * - Menu mobile responsivo
 */

// ======================= INICIALIZAÇÃO =======================
document.addEventListener("DOMContentLoaded", function () {
  initCart();
  initBackToTop();
  // initScrollAnimations(); // COMENTADO - Remove animações de scroll
  initMobileMenu();
  loadCartFromStorage(); // Carrega o carrinho salvo ao iniciar
  removeInitialOpacity(); // Remove opacidade inicial dos elementos
});

// ======================= REMOVE OPACIDADE INICIAL =======================
function removeInitialOpacity() {
  // Remove a opacidade dos cards para que apareçam imediatamente
  document.querySelectorAll('.product-card').forEach(card => {
    card.style.opacity = '1';
    card.style.animation = 'none';
  });

  // Remove a opacidade das seções
  document.querySelectorAll('.section-title').forEach(section => {
    section.style.opacity = '1';
    section.style.animation = 'none';
  });
}

// ======================= CARRINHO DE COMPRAS OTIMIZADO =======================
function initCart() {
  const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
  const cartCountElement = document.querySelector(".cart-count");
  const cartIcon = document.querySelector(".cart-icon");

  // Array para armazenar os itens do carrinho
  let cart = [];

  /**
   * Carrega o carrinho do localStorage quando a página é carregada
   */
  window.loadCartFromStorage = function () {
    const savedCart = localStorage.getItem('cxStoreCart');
    if (savedCart) {
      cart = JSON.parse(savedCart);
      updateCartCount();
      console.log('Carrinho carregado:', cart);
    }
  };

  /**
   * Salva o carrinho no localStorage
   */
  function saveCartToStorage() {
    localStorage.setItem('cxStoreCart', JSON.stringify(cart));
    console.log('Carrinho salvo:', cart);
  }

  /**
   * Atualiza o contador do carrinho com animação
   */
  function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCountElement.textContent = totalItems;

    if (totalItems > 0) {
      cartCountElement.classList.add('active');
      // Animação de pulse no ícone do carrinho
      cartIcon.style.animation = 'none';
      setTimeout(() => {
        cartIcon.style.animation = 'bounceIn 0.5s';
      }, 10);
    } else {
      cartCountElement.classList.remove('active');
    }
  }

  /**
   * Extrai informações do produto do card
   * @param {HTMLElement} button - Botão clicado
   * @returns {Object} Objeto com dados do produto
   */
  function getProductInfo(button) {
    const productCard = button.closest('.product-card');
    const productName = productCard.querySelector('.product-info h3').textContent;
    const priceElement = productCard.querySelector('.price-current');
    const productPrice = priceElement.textContent.replace('R$', '').trim();
    const productImage = productCard.querySelector('.product-image img').src;

    const productId = button.getAttribute('data-id') || productCard.getAttribute('data-id') || 0;

    return {
      id: parseInt(productId),
      name: productName,
      price: productPrice,
      image: productImage
    };
  }

  /**
   * Adiciona produto ao carrinho
   * @param {Object} product - Dados do produto
   */
  function addToCart(product) {
    // Verifica se o produto já existe no carrinho
    const existingProduct = cart.find(item => item.id === product.id);

    if (existingProduct) {
      // Se já existe, incrementa a quantidade
      existingProduct.quantity += 1;
    } else {
      // Se não existe, adiciona novo produto com quantidade 1
      cart.push({
        ...product,
        quantity: 1
      });
    }

    // Salva no localStorage
    saveCartToStorage();

    // Atualiza a interface
    updateCartCount();

    console.log('Produto adicionado:', product);
    console.log('Carrinho atual:', cart);
  }

  /**
   * Anima o botão e fornece feedback visual
   * @param {HTMLElement} button - Botão clicado
   */
  function animateButton(button) {
    const originalHTML = button.innerHTML;
    const productCard = button.closest('.product-card');

    // Altera o botão para o estado "adicionado"
    button.innerHTML = '<i class="fas fa-check"></i> Adicionado!';
    button.classList.add('added');
    button.disabled = true;

    // Adiciona animação ao card do produto
    productCard.style.animation = 'bounceIn 0.6s';

    // Restaura o estado original após 2 segundos
    setTimeout(() => {
      button.innerHTML = originalHTML;
      button.classList.remove('added');
      button.disabled = false;
      productCard.style.animation = '';
    }, 2000);
  }

  /**
   * Mostra notificação de produto adicionado com informações do produto
   * @param {Object} product - Dados do produto adicionado
   */
  function showNotification(product) {
    // Remove notificação anterior se existir
    const existingNotification = document.querySelector('.cart-notification');
    if (existingNotification) {
      existingNotification.remove();
    }

    // Cria elemento de notificação
    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `
      <div class="notification-content">
        <div class="notification-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-details">
          <strong>Produto adicionado ao carrinho!</strong>
          <p>${product.name}</p>
        </div>
        <div class="notification-image">
          <img src="${product.image}" alt="${product.name}">
        </div>
      </div>
    `;

    document.body.appendChild(notification);

    // Adiciona animação de entrada
    setTimeout(() => notification.classList.add('show'), 10);

    // Remove a notificação após 3 segundos
    setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }

  /**
   * Cria o modal do carrinho de compras
   */
  function createCartModal() {
    // Verifica se o modal já existe
    if (document.querySelector('.cart-modal')) return;

    const cartModal = document.createElement('div');
    cartModal.className = 'cart-modal';
    cartModal.innerHTML = `
      <div class="cart-modal-overlay"></div>
      <div class="cart-modal-content">
        <div class="cart-modal-header">
          <h2><i class="fas fa-shopping-bag"></i> Meu Carrinho</h2>
          <button class="cart-modal-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-modal-body">
          <div class="cart-items-container"></div>
        </div>
        <div class="cart-modal-footer">
          <div class="cart-total">
            <span>Total:</span>
            <span class="cart-total-price">R$ 0,00</span>
          </div>
          <button class="cart-checkout-btn" onclick="proceedToCheckout()">
            <i class="fas fa-credit-card"></i> Finalizar Compra
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(cartModal);

    // Event listeners para fechar o modal
    const closeBtn = cartModal.querySelector('.cart-modal-close');
    const overlay = cartModal.querySelector('.cart-modal-overlay');

    closeBtn.addEventListener('click', closeCartModal);
    overlay.addEventListener('click', closeCartModal);
  }

  /**
   * Abre o modal do carrinho
   */
  function openCartModal() {
    createCartModal();
    const modal = document.querySelector('.cart-modal');
    renderCartItems();
    setTimeout(() => modal.classList.add('active'), 10);
    document.body.style.overflow = 'hidden'; // Previne scroll do body
  }

  /**
   * Fecha o modal do carrinho
   */
  function closeCartModal() {
    const modal = document.querySelector('.cart-modal');
    if (modal) {
      modal.classList.remove('active');
      setTimeout(() => modal.remove(), 300);
      document.body.style.overflow = ''; // Restaura scroll do body
    }
  }

  /**
   * Renderiza os itens do carrinho no modal
   */
  function renderCartItems() {
    const container = document.querySelector('.cart-items-container');
    const totalPriceElement = document.querySelector('.cart-total-price');

    if (!container) return;

    // Se o carrinho estiver vazio
    if (cart.length === 0) {
      container.innerHTML = `
        <div class="cart-empty">
          <i class="fas fa-shopping-bag"></i>
          <p>Seu carrinho está vazio</p>
          <button class="continue-shopping-btn" onclick="document.querySelector('.cart-modal-close').click()">
            Continuar Comprando
          </button>
        </div>
      `;
      totalPriceElement.textContent = 'R$ 0,00';
      return;
    }

    // Renderiza cada item do carrinho
    container.innerHTML = cart.map(item => `
      <div class="cart-item" data-id="${item.id}">
        <div class="cart-item-image">
          <img src="${item.image}" alt="${item.name}">
        </div>
        <div class="cart-item-details">
          <h4>${item.name}</h4>
          <p class="cart-item-price">R$ ${item.price}</p>
          <div class="cart-item-quantity">
            <button class="quantity-btn decrease" data-id="${item.id}">
              <i class="fas fa-minus"></i>
            </button>
            <span class="quantity">${item.quantity}</span>
            <button class="quantity-btn increase" data-id="${item.id}">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <button class="cart-item-remove" data-id="${item.id}">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    `).join('');

    // Calcula o total
    const total = cart.reduce((sum, item) => {
      const price = parseFloat(item.price.replace(',', '.'));
      return sum + (price * item.quantity);
    }, 0);

    totalPriceElement.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;

    // Adiciona event listeners para os botões de quantidade e remover
    addCartItemListeners();
  }

  /**
   * Adiciona event listeners aos botões dos itens do carrinho
   */
  function addCartItemListeners() {
    // Botões de aumentar quantidade
    document.querySelectorAll('.quantity-btn.increase').forEach(btn => {
      btn.addEventListener('click', function () {
        const productId = this.dataset.id;
        changeQuantity(productId, 1);
      });
    });

    // Botões de diminuir quantidade
    document.querySelectorAll('.quantity-btn.decrease').forEach(btn => {
      btn.addEventListener('click', function () {
        const productId = this.dataset.id;
        changeQuantity(productId, -1);
      });
    });

    // Botões de remover item
    document.querySelectorAll('.cart-item-remove').forEach(btn => {
      btn.addEventListener('click', function () {
        const productId = this.dataset.id;
        removeFromCart(productId);
      });
    });
  }

  /**
   * Altera a quantidade de um produto no carrinho
   * @param {string} productId - ID do produto
   * @param {number} change - Mudança na quantidade (+1 ou -1)
   */
  function changeQuantity(productId, change) {
    const product = cart.find(item => item.id === productId);

    if (product) {
      product.quantity += change;

      // Remove o produto se a quantidade chegar a 0
      if (product.quantity <= 0) {
        removeFromCart(productId);
        return;
      }

      saveCartToStorage();
      updateCartCount();
      renderCartItems();
    }
  }

  /**
   * Remove um produto do carrinho
   * @param {string} productId - ID do produto
   */
  function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCartToStorage();
    updateCartCount();
    renderCartItems();
  }

  // Event listener para o ícone do carrinho (abre o modal)
  cartIcon.addEventListener('click', function (e) {
    e.preventDefault();
    openCartModal();
  });

  // Event listeners para os botões "Adicionar ao Carrinho"
  addToCartButtons.forEach(button => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Obtém informações do produto
      const productInfo = getProductInfo(this);

      // Adiciona ao carrinho
      addToCart(productInfo);

      // Atualiza a interface
      animateButton(this);
      showNotification(productInfo);
    });
  });

  // Torna a função disponível globalmente para o botão de checkout
  window.proceedToCheckout = function () {
    if (cart.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }

    const checkoutBtn = document.querySelector('.cart-checkout-btn');
    const originalText = checkoutBtn.innerHTML;
    checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
    checkoutBtn.disabled = true;

    const total = cart.reduce((sum, item) => {
      const price = parseFloat(item.price.replace('R$', '').replace('.', '').replace(',', '.'));
      return sum + (price * item.quantity);
    }, 0);

    const dadosPedido = {
      total: total,
      itens: cart.map(item => ({
        id_variacao: item.id,
        quantidade: item.quantity,
        preco: parseFloat(item.price.replace('R$', '').replace('.', '').replace(',', '.'))
      }))
    };

    fetch('processa_venda.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dadosPedido)
    })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          cart = [];
          saveCartToStorage();
          updateCartCount();
          closeCartModal();

          let mensagemZap = `Olá! Acabei de fazer o pedido *#${data.id_pedido}* no site.\n`;
          mensagemZap += `Valor Total: R$ ${total.toFixed(2)}\n`;
          mensagemZap += `Aguardo a confirmação!`;

          window.open(`https://wa.me/5519971338665?text=${encodeURIComponent(mensagemZap)}`, '_blank');

          window.location.href = 'minhas_compras.php';
        } else {
          alert("Erro: " + data.mensagem);
        }
      })
      .catch(error => {
        console.error('Erro:', error);
        alert("Erro de comunicação.");
      })
      .finally(() => {
        checkoutBtn.innerHTML = originalText;
        checkoutBtn.disabled = false;
      });
  };

  // ======================= BOTÃO VOLTAR AO TOPO =======================
  function initBackToTop() {
    const backToTopButton = document.querySelector(".back-to-top");

    /**
     * Mostra/esconde o botão baseado na posição do scroll
     */
    function toggleBackToTop() {
      if (window.scrollY > 300) {
        backToTopButton.classList.add('visible');
      } else {
        backToTopButton.classList.remove('visible');
      }
    }

    // Event listener para scroll
    window.addEventListener('scroll', toggleBackToTop);

    // Event listener para clique no botão
    backToTopButton.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // ======================= MENU MOBILE =======================
  function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (menuToggle && mainNav) {
      menuToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');

        // Altera o ícone
        const icon = menuToggle.querySelector('i');
        if (mainNav.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });
    }
  }
}
