<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$sql = "SELECT consultas.*, 
               animais.nome AS nome_pet,
               usuarios.nome AS nome_tutor
        FROM consultas
        INNER JOIN animais ON consultas.pet_id = animais.id
        LEFT JOIN usuarios ON animais.usuario_id = usuarios.id
        ORDER BY consultas.data_consulta DESC, consultas.horario DESC";

$resultado = mysqli_query($db, $sql);
$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consultas | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <main class="pagina-crud">
        <div class="cabecalho-crud">
            <div>
                <h1>Consultas</h1>
                <p>Agende e gerencie consultas dos pets.</p>
            </div>
            <?php if (isset($_GET['erro']) && $_GET['erro'] == 'veterinario') { ?>
                <p style="color: #b91c1c; font-weight: bold;">
                    Escolha um veterinário antes de confirmar a consulta.
                </p>
            <?php } ?>
            <a href="cadastrar.php" class="botao botao--primario">Nova consulta</a>
        </div>

        <table class="tabela">
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Tutor</th>
                <th>Veterinário</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Motivo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php while ($consulta = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= $consulta['id'] ?></td>
                    <td><?= htmlspecialchars($consulta['nome_pet']) ?></td>
                    <td> <?= htmlspecialchars($consulta['nome_tutor'] ?? 'Não informado') ?></td>
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
                        <a href="editar.php?id=<?= $consulta['id'] ?>">Editar</a>
                        <a href="excluir.php?id=<?= $consulta['id'] ?>">Excluir</a>
                        <a href="status.php?id=<?= $consulta['id'] ?>&status=Confirmada">Confirmar</a>
                        <a href="status.php?id=<?= $consulta['id'] ?>&status=Realizada">Realizada</a>
                        <a href="status.php?id=<?= $consulta['id'] ?>&status=Cancelada">Cancelar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>

    <?php include "../includes/footer.php"; ?>
</body>

</html>