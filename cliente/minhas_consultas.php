<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "
SELECT consultas.*, animais.nome AS nome_pet, animais.especie
FROM consultas
INNER JOIN animais ON consultas.pet_id = animais.id
WHERE animais.usuario_id = $usuario_id
ORDER BY consultas.data_consulta DESC, consultas.horario DESC
";

$resultado = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minhas Consultas | PetCare</title>
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
        <a href="agendar_consulta.php">Agendar consulta</a>
        <a href="../usuarios/sair.php" class="botao botao--fantasma">Sair</a>
    </nav>
</header>

<main>
    <section class="pagina-lista">
        <h1>Minhas consultas</h1>
        <p>Veja as consultas agendadas para seus pets.</p>

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

        <a href="agendar_consulta.php" class="botao botao--primario">
            Agendar nova consulta
        </a>

        <table>
            <tr>
                <th>Pet</th>
                <th>Espécie</th>
                <th>Veterinário</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Motivo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($consulta = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($consulta['nome_pet']) ?></td>
                        <td><?= htmlspecialchars($consulta['especie']) ?></td>
                        <td><?= htmlspecialchars($consulta['veterinario']) ?></td>
                        <td><?= date("d/m/Y", strtotime($consulta['data_consulta'])) ?></td>
                        <td><?= date("H:i", strtotime($consulta['horario'])) ?></td>
                        <td><?= htmlspecialchars($consulta['motivo']) ?></td>

                        <td>
                            <?php
                            $status = trim($consulta['status']);

                            if ($status == 'Agendada') {
                                $corFundo = '#fff3cd';
                                $corTexto = '#856404';
                            } elseif ($status == 'Confirmada') {
                                $corFundo = '#d1ecf1';
                                $corTexto = '#0c5460';
                            } elseif ($status == 'Realizada') {
                                $corFundo = '#d4edda';
                                $corTexto = '#155724';
                            } elseif ($status == 'Cancelada') {
                                $corFundo = '#f8d7da';
                                $corTexto = '#721c24';
                            } else {
                                $corFundo = '#e6f0ea';
                                $corTexto = '#1f4b41';
                            }
                            ?>

                            <span style="
                                display: inline-block;
                                padding: 7px 14px;
                                border-radius: 20px;
                                background-color: <?= $corFundo ?>;
                                color: <?= $corTexto ?>;
                                font-size: 0.82rem;
                                font-weight: 700;
                            ">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </td>

                        <td class="acoes">
                            <?php if ($consulta['status'] != 'Cancelada' && $consulta['status'] != 'Realizada') { ?>
                                <a
                                    href="cancelar_consulta.php?id=<?= $consulta['id'] ?>"
                                    onclick="return confirm('Tem certeza que deseja cancelar esta consulta?')"
                                >
                                    Cancelar
                                </a>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Você ainda não possui consultas agendadas.</td>
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