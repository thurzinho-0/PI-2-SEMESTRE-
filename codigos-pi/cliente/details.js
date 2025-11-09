// =====================================================================
// SCRIPT DE INTERAÇÕES DA PÁGINA DE DETALHES DO PRODUTO
// Cx Store - Streetwear Premium
// =====================================================================

// Aguarda o carregamento completo do DOM antes de executar
document.addEventListener('DOMContentLoaded', function () {
  
  // ===== SELEÇÃO DE ELEMENTOS DO DOM =====
  const mainImage = document.getElementById('mainImage');
  const sizeBtns = Array.from(document.querySelectorAll('.size-btn'));
  const colorSwatches = Array.from(document.querySelectorAll('.color-swatch'));
  const qtyInput = document.getElementById('qtyInput');
  const qtyMinus = document.getElementById('qtyMinus');
  const qtyPlus = document.getElementById('qtyPlus');
  const addToCart = document.getElementById('addToCart');
  const consultBtn = document.getElementById('consultBtn');
  const wishBtn = document.querySelector('.wish-btn');

  // =====================================================================
  // SELEÇÃO DE TAMANHO (comportamento tipo radio button)
  // =====================================================================
  sizeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove a classe 'active' de todos os botões
      sizeBtns.forEach(b => b.classList.remove('active'));
      
      // Adiciona 'active' apenas no botão clicado
      btn.classList.add('active');
    });
  });

  // =====================================================================
  // SELEÇÃO DE COR (swatches coloridos)
  // =====================================================================
  colorSwatches.forEach(swatch => {
    swatch.addEventListener('click', () => {
      // Remove seleção de todos os swatches
      colorSwatches.forEach(s => s.classList.remove('selected'));
      
      // Marca o swatch clicado como selecionado
      swatch.classList.add('selected');
      
      // OPCIONAL: Trocar imagem principal baseado na cor selecionada
      // Descomente as linhas abaixo se tiver imagens específicas por cor
      // const cor = swatch.getAttribute('data-color');
      // mainImage.src = `camiseta-${cor}.jpg`;
    });
  });

  // =====================================================================
  // CONTROLE DE QUANTIDADE (+ e -)
  // =====================================================================
  
  // Botão de diminuir quantidade
  qtyMinus.addEventListener('click', () => {
    let valorAtual = parseInt(qtyInput.value || 1, 10);
    
    // Impede valor menor que 1
    if (valorAtual > 1) {
      qtyInput.value = valorAtual - 1;
    }
  });
  
  // Botão de aumentar quantidade
  qtyPlus.addEventListener('click', () => {
    let valorAtual = parseInt(qtyInput.value || 1, 10);
    qtyInput.value = valorAtual + 1;
  });

  // =====================================================================
  // ADICIONAR AO CARRINHO
  // =====================================================================
  addToCart.addEventListener('click', () => {
    // Captura os valores selecionados
    const tamanhoSelecionado = document.querySelector('.size-btn.active')?.dataset.size || null;
    const corSelecionada = document.querySelector('.color-swatch.selected')?.dataset.color || null;
    const quantidade = parseInt(qtyInput.value || 1, 10);
    
    // Validação: verifica se um tamanho foi selecionado
    if (!tamanhoSelecionado) {
      alert('⚠️ Por favor selecione um tamanho antes de adicionar ao carrinho.');
      return;
    }
    
    // Simula o processo de adicionar ao carrinho
    addToCart.disabled = true;  // Desabilita o botão temporariamente
    addToCart.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ADICIONANDO...';
    
    // Simula delay de processamento (700ms)
    setTimeout(() => {
      // Restaura o botão ao estado original
      addToCart.disabled = false;
      addToCart.innerHTML = 'ADICIONAR À SACOLA <i class="fas fa-shopping-bag"></i>';
      
      // Atualiza o contador do carrinho no header
      const contadorCarrinho = document.querySelector('.cart-count');
      if (contadorCarrinho) {
        const quantidadeAtual = parseInt(contadorCarrinho.textContent || '0', 10);
        contadorCarrinho.textContent = (quantidadeAtual + quantidade).toString();
      }
      
      // Exibe mensagem de confirmação
      alert(
        `✓ Produto adicionado ao carrinho com sucesso!\n\n` +
        `Produto: Camiseta Streetwear Cristal Ball Black\n` +
        `Tamanho: ${tamanhoSelecionado}\n` +
        `Cor: ${corSelecionada || 'Padrão'}\n` +
        `Quantidade: ${quantidade}`
      );
    }, 700);
  });

  // =====================================================================
  // BOTÃO CONSULTAR (abre WhatsApp)
  // =====================================================================
  consultBtn.addEventListener('click', () => {
    // Número do WhatsApp (formato internacional: código do país + DDD + número)
    const numeroWhatsApp = '5519971338665';
    
    // Mensagem pré-formatada
    const mensagem = encodeURIComponent(
      'Olá! Gostaria de saber mais sobre a Camiseta Streetwear Cristal Ball Black.'
    );
    
    // Abre o WhatsApp em nova aba
    window.open(`https://wa.me/${numeroWhatsApp}?text=${mensagem}`, '_blank');
  });

  // =====================================================================
  // BOTÃO DE FAVORITOS / WISHLIST (coração)
  // =====================================================================
  if (wishBtn) {
    wishBtn.addEventListener('click', () => {
      const iconeCoracao = wishBtn.querySelector('i');
      
      // Alterna entre coração vazio (far) e cheio (fas)
      if (iconeCoracao.classList.contains('far')) {
        // Adicionar aos favoritos
        iconeCoracao.classList.remove('far');
        iconeCoracao.classList.add('fas');
        alert('❤️ Produto adicionado aos favoritos!');
        
        // OPCIONAL: Aqui você pode enviar uma requisição para salvar no backend
        // salvarFavorito(produtoId);
        
      } else {
        // Remover dos favoritos
        iconeCoracao.classList.remove('fas');
        iconeCoracao.classList.add('far');
        alert('💔 Produto removido dos favoritos.');
        
        // OPCIONAL: Aqui você pode enviar uma requisição para remover do backend
        // removerFavorito(produtoId);
      }
    });
  }

  // =====================================================================
  // SELEÇÃO AUTOMÁTICA DA PRIMEIRA COR (se existir)
  // =====================================================================
  if (colorSwatches.length > 0) {
    colorSwatches[0].classList.add('selected');
  }

  // =====================================================================
  // VALIDAÇÃO DO INPUT DE QUANTIDADE (evita valores inválidos)
  // =====================================================================
  qtyInput.addEventListener('input', function() {
    let valor = parseInt(this.value, 10);
    
    // Se não for um número ou for menor que 1, define como 1
    if (isNaN(valor) || valor < 1) {
      this.value = 1;
    }
  });

  // =====================================================================
  // LOG DE INICIALIZAÇÃO (pode ser removido em produção)
  // =====================================================================
  console.log('✅ Página de detalhes carregada com sucesso!');
  console.log(`📦 Produto: Camiseta Streetwear Cristal Ball Black`);
  console.log(`🎨 Cores disponíveis: ${colorSwatches.length}`);
  console.log(`📏 Tamanhos disponíveis: ${sizeBtns.length}`);
});

// =====================================================================
// FIM DO SCRIPT
// =====================================================================
