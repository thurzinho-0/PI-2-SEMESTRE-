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
  window.loadCartFromStorage = function() {
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
    
    // Gera um ID único baseado no nome do produto
    const productId = productName.toLowerCase().replace(/\s+/g, '-');
    
    return {
      id: productId,
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
      btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        changeQuantity(productId, 1);
      });
    });

    // Botões de diminuir quantidade
    document.querySelectorAll('.quantity-btn.decrease').forEach(btn => {
      btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        changeQuantity(productId, -1);
      });
    });

    // Botões de remover item
    document.querySelectorAll('.cart-item-remove').forEach(btn => {
      btn.addEventListener('click', function() {
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
  cartIcon.addEventListener('click', function(e) {
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
  window.proceedToCheckout = function() {
    alert('Você sera adicionado para finalização!\n\nTotal de itens: ' + cart.length);
    console.log('Itens do carrinho:', cart);
  };
}

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
// ======================= ESTILOS CSS ADICIONAIS INJETADOS =======================
const style = document.createElement('style');
style.textContent = `
  /* Animações */
  @keyframes slideInRight {
    from {
      transform: translateX(400px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes slideOutRight {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(400px);
      opacity: 0;
    }
  }

  /* Notificação do Carrinho */
  .cart-notification {
    position: fixed;
    top: 100px;
    right: -400px;
    background: white;
    padding: 1.2rem;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    z-index: 10000;
    min-width: 320px;
    max-width: 400px;
    transition: right 0.3s ease;
    border-left: 4px solid #51cf66;
  }

  .cart-notification.show {
    right: 20px;
  }

  .notification-content {
    display: flex;
    gap: 1rem;
    align-items: center;
  }

  .notification-icon {
    font-size: 2rem;
    color: #51cf66;
    flex-shrink: 0;
  }

  .notification-details {
    flex: 1;
  }

  .notification-details strong {
    display: block;
    margin-bottom: 0.3rem;
    color: #212529;
    font-size: 0.95rem;
  }

  .notification-details p {
    margin: 0;
    font-size: 0.85rem;
    color: #6c757d;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .notification-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
    flex-shrink: 0;
  }

  .notification-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  /* Modal do Carrinho */
  .cart-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }

  .cart-modal.active {
    opacity: 1;
    visibility: visible;
  }

  .cart-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
  }

  .cart-modal-content {
    position: relative;
    width: 100%;
    max-width: 450px;
    height: 100vh;
    background: white;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
  }

  .cart-modal.active .cart-modal-content {
    transform: translateX(0);
  }

  .cart-modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
  }

  .cart-modal-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .cart-modal-close {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    border: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #6c757d;
    transition: all 0.3s ease;
  }

  .cart-modal-close:hover {
    background: #e53935;
    color: white;
    border-color: #e53935;
    transform: rotate(90deg);
  }

  .cart-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
  }

  .cart-items-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  /* Item do Carrinho */
  .cart-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    position: relative;
    transition: all 0.3s ease;
  }

  .cart-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .cart-item-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    flex-shrink: 0;
  }

  .cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .cart-item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .cart-item-details h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
    line-height: 1.3;
    color: #212529;
  }

  .cart-item-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #e53935;
    margin: 0;
  }

  .cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-top: auto;
  }

  .quantity-btn {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: white;
    border: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    color: #6c757d;
    transition: all 0.3s ease;
  }

  .quantity-btn:hover {
    background: #000;
    color: white;
    border-color: #000;
  }

  .quantity {
    font-weight: 600;
    color: #212529;
    min-width: 20px;
    text-align: center;
  }

  .cart-item-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: white;
    border: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    color: #6c757d;
    transition: all 0.3s ease;
  }

  .cart-item-remove:hover {
    background: #e53935;
    color: white;
    border-color: #e53935;
    transform: scale(1.1);
  }

  /* Carrinho Vazio */
  .cart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    text-align: center;
    color: #6c757d;
  }

  .cart-empty i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.3;
  }

  .cart-empty p {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
  }

  .continue-shopping-btn {
    padding: 0.8rem 2rem;
    background: #000;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
  }

  .continue-shopping-btn:hover {
    background: #e53935;
    transform: translateY(-2px);
  }

  /* Rodapé do Modal */
  .cart-modal-footer {
    padding: 1.5rem;
    border-top: 2px solid #e9ecef;
    background: #f8f9fa;
  }

  .cart-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    font-weight: 700;
  }

  .cart-total-price {
    color: #e53935;
    font-size: 1.5rem;
  }

  .cart-checkout-btn {
    width: 100%;
    padding: 1rem;
    background: #000;
    color: white;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
  }

  .cart-checkout-btn:hover {
    background: #e53935;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
  }

  /* Menu Mobile */
  .main-nav.active {
    display: block !important;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 1rem;
  }

  .main-nav.active ul {
    flex-direction: column;
    gap: 1rem;
  }

  /* Responsividade */
  @media (max-width: 480px) {
    .cart-modal-content {
      max-width: 100%;
    }

    .cart-notification {
      min-width: 280px;
      right: -300px;
    }

    .cart-notification.show {
      right: 10px;
    }
  }
`;
document.head.appendChild(style);
