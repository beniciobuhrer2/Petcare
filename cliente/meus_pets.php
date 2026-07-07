<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM animais WHERE usuario_id = $usuario_id ORDER BY id DESC";
$resultado = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meus Pets | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<header class="topbar">
    <div class="topbar__marca">
        <a href="painel.php">PetCare</a>
    </div>

    <nav class="topbar__nav">
        <a href="painel.php">Início</a>
        <a href="cadastrar_pet.php">Cadastrar pet</a>
        <a href="agendar_consulta.php">Agendar consulta</a>
        <a href="minhas_consultas.php">Minhas consultas</a>
        <a href="../usuarios/sair.php" class="botao botao--fantasma">Sair</a>
    </nav>
</header>

<main>
    <section class="pagina-lista">
        <h1>Meus pets</h1>
        <p>Veja os pets cadastrados na sua conta.</p>

        <?php if (isset($_SESSION['mensagem'])) {
            $mensagem = $_SESSION['mensagem'];
            unset($_SESSION['mensagem']);
        ?>
            <div id="mensagem-sucesso" style="
                background-color: #DDF3E5;
                color: #1F6B45;
                border: 1px solid #B8DFC7;
                padding: 14px 18px;
                border-radius: 12px;
                font-weight: 700;
                margin: 18px 0;
                transition: opacity 0.5s ease;
            ">
                <?= htmlspecialchars($mensagem) ?>
            </div>

            <script>
                setTimeout(function () {
                    const mensagem = document.getElementById("mensagem-sucesso");

                    if (mensagem) {
                        mensagem.style.opacity = "0";

                        setTimeout(function () {
                            mensagem.style.display = "none";
                        }, 500);
                    }
                }, 3000);
            </script>
        <?php } ?>

        <a href="cadastrar_pet.php" class="botao botao--primario">
            Cadastrar novo pet
        </a>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Idade</th>
            </tr>

            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($pet = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $pet['id'] ?></td>
                        <td><?= htmlspecialchars($pet['nome']) ?></td>
                        <td><?= htmlspecialchars($pet['especie']) ?></td>
                        <td><?= htmlspecialchars($pet['raca']) ?></td>
                        <td><?= htmlspecialchars($pet['idade']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Você ainda não cadastrou nenhum pet.</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>
</main>

<footer class="rodape">
    <p>PetCare © 2026 — Projeto Integrador</p>
</footer>

</body>

</html>