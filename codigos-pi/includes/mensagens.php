<?php if (isset($_SESSION['msg_sucesso']) && $_SESSION['msg_sucesso']): ?>
    <div class="mensagem sucesso">
        <?= $_SESSION['msg_sucesso']; ?>
    </div>
    <?php unset($_SESSION['msg_sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['msg_erro']) && $_SESSION['msg_erro']): ?>
    <div class="mensagem erro">
        <?= $_SESSION['msg_erro']; ?>
    </div>
    <?php unset($_SESSION['msg_erro']); ?>
<?php endif; ?>
