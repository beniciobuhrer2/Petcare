<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Cliente | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="topbar">
    <div class="topbar__marca">
        <a href="painel.php">PetCare</a>
    </div>

    <nav class="topbar__nav">
        <a href="painel.php">Início</a>
        <a href="meus_pets.php">Meus pets</a>
        <a href="cadastrar_pet.php">Cadastrar pet</a>
        <a href="agendar_consulta.php">Agendar consulta</a>
        <a href="minhas_consultas.php">Minhas consultas</a>
        <span class="topbar__usuario">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
        <a href="../usuarios/sair.php" class="botao botao--fantasma">Sair</a>
    </nav>
</header>

<main>
    <section class="painel">
        <div class="painel__cabecalho">
            <h1>Área do Cliente</h1>
            <p>Gerencie seus pets e agende consultas.</p>
        </div>

        <div class="cartoes">
            <a href="cadastrar_pet.php" class="cartao">
                <span class="cartao__icone">🐾</span>
                <h2>Cadastrar pet</h2>
                <p>Adicione os dados do seu animal.</p>
            </a>

            <a href="meus_pets.php" class="cartao">
                <span class="cartao__icone">🐶</span>
                <h2>Meus pets</h2>
                <p>Veja os pets cadastrados na sua conta.</p>
            </a>

            <a href="agendar_consulta.php" class="cartao">
                <span class="cartao__icone">🩺</span>
                <h2>Agendar consulta</h2>
                <p>Marque uma consulta para seu pet.</p>
            </a>

            <a href="minhas_consultas.php" class="cartao">
                <span class="cartao__icone">📅</span>
                <h2>Minhas consultas</h2>
                <p>Acompanhe suas consultas agendadas.</p>
            </a>
        </div>
    </section>
</main>

<footer class="rodape">
    <p>PetCare © 2026 — Projeto Integrador</p>
</footer>

</body>
</html>