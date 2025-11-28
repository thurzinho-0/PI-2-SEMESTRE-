<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
require_once('../classes/Cor.php');
require_once('../classes/Tamanho.php');
$mensagens = include('../config/mensagens.php');

$produto_info = false;
$id_produto = null;

if (!isset($_GET['id_produto']) || empty($_GET['id_produto'])) {
    $_SESSION['msg_erro'] = $mensagens['id_vazio'];
    header("Location: produtos.php");
    exit();
}

$id_produto = $_GET['id_produto'];

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);
$cor = new Cor($db);
$tamanho = new Tamanho($db);

$produto->id = $id_produto;

$produto_info = $produto->buscaID();

if (!$produto_info) {
    $_SESSION['msg_erro'] = "Produto não encontrado.";
    header("Location: produtos.php");
    exit();
}

$lista_cores = $cor->listarAtivo();
$lista_tamanhos = $tamanho->listarAtivo();
$lista_variacoes = $produto->listarVariacoes();
$lista_imagens = $produto->listarImagens();

if (isset($_GET['novo']) && $_GET['novo'] == '1') {
    $_SESSION['msg_sucesso'] = $mensagens['produto_criado'] . " Agora, adicione as imagens e variações.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/css/gerenciar_variacoes.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <title>Gerenciar Produto - <?= htmlspecialchars($produto_info['nome']) ?></title>
    </head>

<body>
    <header>
        <img src="../assets/imagens/Logo.jpg" alt="CX Store Logo" />
    </header>

    <div class="top-nav">
        <a href="produtos.php" class="btn-voltar">✓ Concluir e Voltar</a>
        <a href="../logout.php" class="btn-sair">Sair</a>
    </div>

    <h2>GERENCIAR PRODUTO</h2>

    <?php include('../includes/mensagens.php'); ?>

    <div class="info-produto">
        <?php if (!empty($produto_info['imagem'])): ?>
            <img src="../assets/uploads/<?= htmlspecialchars($produto_info['imagem']) ?>" alt="<?= htmlspecialchars($produto_info['nome']) ?>">
        <?php endif; ?>
        <h3><?= htmlspecialchars($produto_info['nome']) ?></h3>
    </div>

    <section class="form-container">
        <h3>Imagens Secundárias</h3>

        <form action="processa_add_imagens.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?= $id_produto ?>">
            <div class="form-group">
                <label for="imagens_secundarias">Adicionar novas imagens:</label>
                <input type="file" id="imagens_secundarias" name="imagens[]" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn-adicionar">Adicionar Imagens</button>
        </form>

        <h3 style="margin-top: 20px;">Imagens Cadastradas</h3>
        <div class="imagem-galeria">
            <?php
            if ($lista_imagens->num_rows == 0) {
                echo '<p class="empty-message" style="grid-column: 1 / -1;">Nenhuma imagem secundária cadastrada.</p>';
            } else {
                while ($img = $lista_imagens->fetch_assoc()) {
                    if (!empty($img['caminho'])) {
                        echo '<div class="imagem-item">';
                        echo '<img src="../assets/uploads/' . htmlspecialchars($img['caminho']) . '" >';
                        echo '<a href="excluir_imagem.php?id_imagem=' . $img['id'] . '&id_produto=' . $id_produto . '" class="excluir-img" title="Excluir Imagem">&times;</a>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </section>

    <section class="form-container">
        <h3>Variações (Cor e Tamanho)</h3>

        <form action="processa_add_variacoes.php" method="POST">
            <input type="hidden" name="id_produto" value="<?= $id_produto ?>">

            <div class="form-group">
                <label>Cores Ativas:</label>
                <div class="checkbox-grid">
                    <?php while ($cor = $lista_cores->fetch_assoc()): ?>
                        <label>
                            <input type="checkbox" name="cores[]" value="<?= $cor['id'] ?>">
                            <?= htmlspecialchars($cor['nome']) ?>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Tamanhos Ativos:</label>
                <div class="checkbox-grid">
                    <?php while ($tamanho = $lista_tamanhos->fetch_assoc()): ?>
                        <label>
                            <input type="checkbox" name="tamanhos[]" value="<?= $tamanho['id'] ?>">
                            <?= htmlspecialchars($tamanho['nome']) ?>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>

            <button type="submit" class="btn-adicionar">Criar Variações</button>
        </form>
    </section>

    <section class="lista-container">
        <h3>Variações Criadas</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Cor</th>
                        <th>Tamanho</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_variacoes->num_rows == 0) {
                        echo '<tr><td colspan="3" class="empty-message">Nenhuma variação cadastrada para este produto.</td></tr>';
                    } else {
                        while ($var = $lista_variacoes->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($var['nome_cor'] ?? 'N/A') . '</td>';
                            echo '<td>' . htmlspecialchars($var['nome_tamanho'] ?? 'N/A') . '</td>';
                            echo '<td>';
                            echo '<a href="excluir_variacao.php?id_variacao=' . $var['id_variacao'] . '&id_produto=' . $id_produto . '" class="btn-acao excluir">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

</body>

</html>