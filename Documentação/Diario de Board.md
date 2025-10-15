# Diario de Bordo / Planejamento Diário – Projeto E-commerce

## Equipe
- **Frontend + Documentação:** Arthur e Benevides (interface, HTML, CSS, JS, layout, documentação)  
- **Backend:** John e Mateus (PHP, banco de dados, APIs)  

---

## 1. Cadastro e Login

| Página           | Responsável                  | Tarefas                                         | Observações                       |
|-----------------|-----------------------------|------------------------------------------------|----------------------------------|
| Cadastro         | Arthur + Benevides          | Formulário: Nome, Email, Senha, Telefone      | Validação front                  |
| Login            | Arthur + Benevides          | Formulário: Email, Senha                       | Botão “Entrar”                   |
| Esqueceu senha   | Arthur + Benevides / John + Mateus | Front: formulário reset senha, Back: envio de token/email | Integração front-back |

---

## 2. Home / Index

| Página | Responsável        | Tarefas                                           | Observações                         |
|--------|------------------|-------------------------------------------------|------------------------------------|
| Home   | Arthur + Benevides | Catálogo, Categorias, Destaques, Botão Perfil, Carrinho | Layout responsivo, destaque de produtos |

---

## 3. Carrinho e Perfil

| Página        | Responsável         | Tarefas                                         | Observações                        |
|---------------|------------------|------------------------------------------------|-----------------------------------|
| Carrinho      | Arthur + Benevides | Lista itens, subtotal, alterar quantidade, remover, parcelamento | Link “Adicionar mais itens” para catálogo |
| Perfil        | Arthur + Benevides | Visão geral do cliente                          | Botões para editar senha e dados  |
| Editar Senha  | Arthur + Benevides | Formulário dentro do perfil                     | Validar senhas iguais             |
| Editar Dados  | Arthur + Benevides | Nome, Email, Telefone                            | Front validações                  |

---

## 4. Histórico de Compras / Minhas Vendas

| Página          | Responsável       | Tarefas                                | Observações              |
|-----------------|-----------------|---------------------------------------|-------------------------|
| Minhas Compras   | Arthur + Benevides | Histórico de pedidos, status           | Cliente logado          |
| Minhas Vendas (ADM) | John + Mateus   | Lista vendas por produto/vendedor      | Backend com filtros     |

---

## 5. Painel ADM

| Página                  | Responsável     | Tarefas                                   | Observações                 |
|-------------------------|----------------|------------------------------------------|----------------------------|
| Painel ADM – Visão Geral | John + Mateus  | Métricas, atalhos CRUD produtos/anúncios | Dashboard administrativo   |
| Edição Senha ADM        | John + Mateus  | Alterar senha                             | Perfil ADM                 |
| Edição Dados ADM        | John + Mateus  | Nome, Email, Telefone                      | Backend + front simples    |

---

## 6. Produto e Aprovação

| Página               | Responsável         | Tarefas                                         | Observações                       |
|---------------------|------------------|------------------------------------------------|----------------------------------|
| Página Produto       | Arthur + Benevides | Nome, imagens, tamanhos, cores, preço, subtotal, botão “Adicionar à sacola” | Responsivo, fácil de navegar     |
| Aprovação de Vendas  | John + Mateus     | Mostrar preço, data, botão Aprovar/Reprovar   | Workflow de aprovação no backend |

---

## Observações Gerais
- **Arthur + Benevides → Frontend e documentação**  
- **John + Mateus → Backend, banco de dados e APIs**  
- Atualizar diariamente progresso de cada página para controle
