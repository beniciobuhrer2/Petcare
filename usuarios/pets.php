<?php

session_start();

require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];

$sqlUsuario = "SELECT * FROM usuarios WHERE id = $id";
$resultadoUsuario = mysqli_query($db, $sqlUsuario);
$usuario = mysqli_fetch_assoc($resultadoUsuario);

if (!$usuario) {
    header("Location: listar.php");
    exit;
}

$nomeUsuario = $usuario['nome'];

$sqlAnimais = "SELECT * FROM animais WHERE dono_nome = '$nomeUsuario'";
$resultadoAnimais = mysqli_query($db, $sqlAnimais);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pets do usuário | PetCare</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body>

<header class="topbar">

    <div class="topbar__marca">
        <a href="../index.php">PetCare</a>
    </div>

    <nav class="topbar__nav">

        <a href="../index.php">Início</a>

        <a href="../animais/listar.php">Pets</a>

        <a href="../consultas/listar.php">Consultas</a>

        <a href="listar.php">Usuários</a>

        <span class="topbar__usuario">
            Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
        </span>

        <a href="sair.php" class="botao botao--fantasma">
            Sair
        </a>

    </nav>

</header>

<main>

    <section class="pagina-pets-usuario">

        <div class="pets-usuario-cabecalho">

            <div>

                <h1>Pets de <?= htmlspecialchars($usuario['nome']) ?></h1>

                <p>
                    Animais cadastrados para este usuário.
                </p>

            </div>

            <a href="listar.php" class="botao botao--fantasma">
                Voltar
            </a>

        </div>


        <div class="pets-usuario-lista">

            <?php if (mysqli_num_rows($resultadoAnimais) > 0): ?>

                <?php while ($animal = mysqli_fetch_assoc($resultadoAnimais)): ?>

                    <div class="pet-usuario-card">

                        <div class="pet-usuario-icone">
                            🐾
                        </div>

                        <div class="pet-usuario-info">

                            <h2>
                                <?= htmlspecialchars($animal['nome']) ?>
                            </h2>

                            <p>
                                <strong>Espécie:</strong>
                                <?= htmlspecialchars($animal['especie']) ?>
                            </p>

                            <p>
                                <strong>Raça:</strong>
                                <?= htmlspecialchars($animal['raca']) ?>
                            </p>

                            <p>
                                <strong>Idade:</strong>
                                <?= htmlspecialchars($animal['idade']) ?> anos
                            </p>

                        </div>

                        <a
                            href="../animais/editar.php?id=<?= $animal['id'] ?>"
                            class="botao botao--primario"
                        >
                            Ver pet
                        </a>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="sem-pets">

                    <span>🐾</span>

                    <h2>Nenhum pet encontrado</h2>

                    <p>
                        Este usuário ainda não possui pets cadastrados.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </section>

</main>

<footer class="rodape">

    <p>
        PetCare &copy; <?= date('Y') ?>
        — Todos os direitos reservados - Benício Buhrer de Lima
    </p>

</footer>

</body>

</html>