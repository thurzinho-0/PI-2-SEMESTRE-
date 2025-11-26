# **Cx Store - E-commerce**

## **Funcionalidades Implementadas**

### **Frontend (Interface com o Usuário)**

#### **Página Inicial (Home)**
- Exibe **produtos em destaque** e **categorias**.
- **Design responsivo** utilizando **HTML/CSS**, garantindo ótima visualização em desktop, tablet e celular.
- **Interatividade com JavaScript**:
  - **Sliders** para exibição de produtos e promoções.
  - **Animações** para transições suaves e melhoria da experiência do usuário.
  - Exibição de **produtos populares**, **novidades** e **ofertas especiais**.

#### **Carrinho de Compras**
- Funcionalidades de **gestão do carrinho**:
  - **Adicionar**, **remover** ou **alterar a quantidade** de itens.
  - Exibição do **subtotal** e **total** do pedido, com atualização dinâmica.
  - **AJAX** para atualização do carrinho sem a necessidade de recarregar a página, tornando a experiência mais fluida.
  - **Exclusão de itens** e **cálculo automático** de preços e descontos.

#### **Login e Recuperação de Senha**
- **Formulários de login** e **recuperação de senha** implementados com **HTML/CSS**.
- **Validação de dados** no frontend com **JavaScript**, para garantir que os dados inseridos pelo usuário sejam válidos.
- **Autenticação de login** realizada em **PHP**, validando as credenciais do usuário.
- **Recuperação de senha** com envio de **token** para o **email** do usuário, permitindo a redefinição de senha de forma segura.

---

### **Backend (Lógica do Sistema)**

#### **Autenticação**
- **Sistema de login** seguro:
  - Validação de usuários no **banco de dados** com **PHP**.
  - Armazenamento seguro das senhas utilizando **hashing** (ex.: **bcrypt**).
- **Recuperação de senha**:
  - Envio de **token de recuperação** para o **email** do usuário.
  - **Validação do token** e **atualização de senha**.

#### **Gerenciamento de Pedidos**
- **Gestão de pedidos**:
  - Controle de **status de pedidos**: pendente, aprovado e rejeitado.
  - Relacionamento entre **usuário** e **pedidos** no banco de dados.
- **Edição de pedidos**:
  - Alteração de status do pedido (de "pendente" para "aprovado" ou "rejeitado").
  - Integração com o sistema de **estoque** para garantir a disponibilidade dos produtos no pedido.

---

### **Funcionalidades de Admin**

#### **Painel Administrativo**
- Interface dedicada para **administradores** com controle total sobre os produtos e pedidos.
- **Visão geral dos pedidos**:
  - **Listagem de pedidos** com filtros por status (pendente, aprovado, rejeitado).
  - **Aprovação e rejeição de pedidos** diretamente no painel.
- **Gestão de produtos**:
  - **Edição de informações do produto**: preço, estoque, descrição, imagem.
  - **Adição de novos produtos** e **exclusão de produtos**.
  - **Atualização de preços** e **estoque** em tempo real.

---

## **Tecnologias Usadas**

- **Frontend**:
  - **HTML** e **CSS**: Para estruturação e estilização da interface do usuário.
  - **JavaScript (AJAX)**: Para tornar o sistema dinâmico, com **atualização do carrinho** e outras interações em tempo real.
  - **Frameworks**: **Bootstrap** para design responsivo e **jQuery** para facilitar as interações.

- **Backend**:
  - **PHP**:
    - **Autenticação de usuários** (login e recuperação de senha).
    - **Gestão de pedidos** (controle de status, relacionamento com o estoque).
    - **Envio de emails** para notificações (como a recuperação de senha).

- **Banco de Dados**:
  - **MySQL** ou **MariaDB**:
    - **Relacionamentos entre usuários, pedidos e produtos**.
    - **Chaves primárias (PK)** e **chaves estrangeiras (FK)** para garantir a integridade referencial.
    - Tabelas para gerenciar **produtos**, **pedidos** e **usuários**.

---

## **Como Rodar o Projeto Localmente**

### **Pré-requisitos**

1. Ter o **PHP** instalado (versão 7.x ou superior).
2. Ter o **MySQL** ou **MariaDB** instalado.
3. Um **servidor local** (ex.: XAMPP ou WAMP) configurado com **Apache** e **PHP**.
