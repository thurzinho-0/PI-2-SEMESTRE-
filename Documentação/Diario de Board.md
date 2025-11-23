<<<<<<< HEAD
# Diário de Bordo / Planejamento Diário – Projeto E-commerce
**Data de Definição de Funções: 07/10/2025**

---

## Equipe
- **Frontend + Documentação**: Arthur e Benevides (responsáveis por interface, HTML, CSS, JS, layout, documentação)
- **Backend**: John e Mateus (responsáveis por PHP, banco de dados, APIs)

---

## Cronograma e Tarefas Realizadas

### **03/09 - Entrevista com o cliente**
- Realizada entrevista inicial para alinhar os requisitos e funcionalidades do sistema com o cliente.

### **24/09 - Perguntas adicionais com o cliente**
- Realizadas novas perguntas ao cliente para obter mais informações detalhadas sobre o projeto.

### **29/09 - Início da prototipação**
- Começo da criação da prototipação inicial do sistema.

### **03/10 - Conversamos com o professor Nilton sobre melhorias no PI**
- Discussão sobre melhorias no controle de vendas para o Administrador e no processo de compras para o cliente.

### **06/10 - Validação da prototipação com o cliente**
- Apresentação da prototipação e validação com o cliente para garantir que as funcionalidades atendem às suas expectativas.

### **08/10 - Início da codificação do projeto**
- Início da codificação do sistema com o desenvolvimento da estrutura inicial.

### **10/10 - Início da modelagem do banco de dados**
- Primeiros passos para modelar o banco de dados, criando as tabelas e relações entre elas.

### **17/10 - Finalização do Cadastro (Frontend e Backend PHP)**
- Conclusão da implementação da tela de cadastro, tanto no frontend quanto no backend em PHP.

### **21/10 - Início da implementação da Home e Carrinho**
- Começo da construção da página home e do carrinho de compras, com integração ao banco de dados para o cadastro de produtos.

### **28/10 - Finalização da página Home e início do painel de Administração**
- Conclusão do desenvolvimento da página home e início da construção do painel de administração, com foco nas melhorias do controle de vendas e gestão de pedidos.

---

## Planejamento e Tarefas em Andamento

### 1. **Cadastro e Login**
| Página           | Responsável                  | Tarefas                                        | Observações                    |
|-----------------|-----------------------------|-----------------------------------------------|-------------------------------|
| Cadastro         | Arthur + Benevides           | Formulário: Nome, Email, Senha, Telefone     | Validação no frontend          |
| Login            | Arthur + Benevides           | Formulário: Email, Senha                     | Botão “Entrar”                 |
| Esqueceu senha   | Arthur + Benevides / John + Mateus | Frontend: Formulário de reset de senha, Backend: Envio de token/email | Integração frontend-backend   |

### 2. **Home / Index**
| Página | Responsável         | Tarefas                                         | Observações                          |
|--------|---------------------|------------------------------------------------|--------------------------------------|
| Home   | Arthur + Benevides   | Catálogo, Categorias, Destaques, Botão Perfil, Carrinho | Layout responsivo, destaque de produtos |

### 3. **Carrinho e Perfil**
| Página        | Responsável         | Tarefas                                         | Observações                        |
|---------------|---------------------|------------------------------------------------|-----------------------------------|
| Carrinho      | Arthur + Benevides   | Lista de itens, subtotal, alteração de quantidade, remoção, parcelamento | Link "Adicionar mais itens" para catálogo |
| Perfil        | Arthur + Benevides   | Visão geral do cliente                         | Botões para editar senha e dados |
| Editar Senha  | Arthur + Benevides   | Formulário dentro do perfil                    | Validar senhas iguais             |
| Editar Dados  | Arthur + Benevides   | Nome, Email, Telefone                          | Validação no frontend             |

### 4. **Histórico de Compras / Minhas Vendas**
| Página          | Responsável      | Tarefas                                        | Observações                        |
|-----------------|------------------|-----------------------------------------------|-----------------------------------|
| Minhas Compras  | Arthur + Benevides | Histórico de pedidos, status                   | Cliente logado                    |
| Minhas Vendas   | John + Mateus    | Listagem de vendas por produto/vendedor        | Backend com filtros               |

### 5. **Painel ADM**
| Página                 | Responsável     | Tarefas                                         | Observações                        |
|------------------------|-----------------|------------------------------------------------|-----------------------------------|
| Painel ADM – Visão Geral | John + Mateus   | Métricas, atalhos CRUD de produtos/anúncios   | Dashboard administrativo         |
| Edição Senha ADM       | John + Mateus   | Alterar senha                                   | Perfil ADM                        |
| Edição Dados ADM       | John + Mateus   | Nome, Email, Telefone                          | Backend e frontend simples        |

### 6. **Produto e Aprovação**
| Página               | Responsável         | Tarefas                                         | Observações                        |
|---------------------|---------------------|------------------------------------------------|-----------------------------------|
| Página Produto       | Arthur + Benevides  | Nome, imagens, tamanhos, cores, preço, subtotal, botão “Adicionar à sacola” | Responsivo, fácil de navegar     |
| Aprovação de Vendas  | John + Mateus       | Mostrar preço, data, botão Aprovar/Reprovar    | Workflow de aprovação no backend |

---

## **Observações Gerais**
- **Arthur + Benevides → Responsáveis pelo Frontend e documentação.**
- **John + Mateus → Responsáveis pelo Backend, banco de dados e APIs.**
- **Atualizar diariamente o progresso de cada página para controle interno e revisão contínua.**

=======
# Diario de Board / Planejamento Diário – Projeto E-commerce

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
>>>>>>> origin/backend
