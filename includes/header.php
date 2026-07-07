<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = $base ?? '..';
$logado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
?>
<header class="topbar">
    <a href="<?= $base ?>/index.php" class="topbar__marca">
        <span>PetCare</span>
    </a>

    <nav class="topbar__nav">
        <a href="<?= $base ?>/index.php">Início</a>

        <?php if ($logado): ?>
            <a href="<?= $base ?>/animais/listar.php">Pets</a>
            <a href="<?= $base ?>/consultas/listar.php">Consultas</a>
            <a href="<?= $base ?>/usuarios/listar.php">Usuários</a>
            <span class="topbar__usuario">Olá, <?= htmlspecialchars($nomeUsuario) ?></span>
            <a href="<?= $base ?>/usuarios/sair.php" class="botao botao--fantasma">Sair</a>
        <?php else: ?>
            <a href="<?= $base ?>/usuarios/cadastrar.php">Cadastrar</a>
            <a href="<?= $base ?>/usuarios/login.php" class="botao botao--fantasma">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
