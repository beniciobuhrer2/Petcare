<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once "../config/db.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM consultas WHERE id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$consulta = mysqli_fetch_assoc($resultado);

if (!$consulta) {
    die("Consulta não encontrada.");
}

$pets = mysqli_query($db, "SELECT id, nome FROM animais ORDER BY nome ASC");

if (isset($_POST['salvar'])) {
    $pet_id = $_POST['pet_id'];
    $veterinario = trim($_POST['veterinario']);
    $data_consulta = $_POST['data_consulta'];
    $horario = $_POST['horario'];
    $motivo = trim($_POST['motivo']);
    $observacoes = trim($_POST['observacoes']);

    $sqlVerifica = "SELECT id FROM consultas
                    WHERE veterinario = ?
                    AND data_consulta = ?
                    AND horario = ?
                    AND id != ?
                    AND status != 'Cancelada'";

    $stmtVerifica = mysqli_prepare($db, $sqlVerifica);
    mysqli_stmt_bind_param($stmtVerifica, "sssi", $veterinario, $data_consulta, $horario, $id);
    mysqli_stmt_execute($stmtVerifica);

    $resultadoVerifica = mysqli_stmt_get_result($stmtVerifica);

    if (mysqli_num_rows($resultadoVerifica) > 0) {
        $erro = "Este veterinário já possui uma consulta nesse dia e horário.";
    } else {
        $sqlUpdate = "UPDATE consultas
                      SET pet_id = ?, veterinario = ?, data_consulta = ?, horario = ?, motivo = ?, observacoes = ?
                      WHERE id = ?";

        $stmtUpdate = mysqli_prepare($db, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "isssssi", $pet_id, $veterinario, $data_consulta, $horario, $motivo, $observacoes, $id);
        mysqli_stmt_execute($stmtUpdate);

        header("Location: listar.php");
        exit;
    }
}

$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Consulta | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <main class="pagina-form">
        <form method="POST" class="formulario">
            <h1>Editar consulta</h1>

            <?php if (isset($erro)) { ?>
                <p style="color: #b91c1c; font-weight: bold;">
                    <?= $erro ?>
                </p>
            <?php } ?>

            <label>Pet</label>
            <select name="pet_id" required>
                <?php while ($pet = mysqli_fetch_assoc($pets)): ?>
                    <option value="<?= $pet['id'] ?>" <?= $pet['id'] == $consulta['pet_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($pet['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Veterinário</label>
            <select name="veterinario" required>
                <option value="">Selecione um veterinário</option>

                <option value="Dr. Pug" <?= $consulta['veterinario'] == 'Dr. Pug' ? 'selected' : '' ?>>
                    Dr. Pug
                </option>

                <option value="Dra. Sabrina" <?= $consulta['veterinario'] == 'Dra. Sabrina' ? 'selected' : '' ?>>
                    Dra. Sabrina
                </option>

                <option value="Dr. Maurício" <?= $consulta['veterinario'] == 'Dr. Maurício' ? 'selected' : '' ?>>
                    Dr. Maurício
                </option>
            </select>

            <label>Data da consulta</label>
            <input type="date" name="data_consulta" value="<?= $consulta['data_consulta'] ?>" required>

            <label>Horário</label>
            <input type="time" name="horario" value="<?= substr($consulta['horario'], 0, 5) ?>" required>

            <label>Motivo</label>
            <input type="text" name="motivo" value="<?= htmlspecialchars($consulta['motivo']) ?>" required>

            <label>Observações</label>
            <textarea name="observacoes" rows="4"><?= htmlspecialchars($consulta['observacoes']) ?></textarea>

            <button type="submit" name="salvar" class="botao botao--primario">Salvar</button>
            <a href="listar.php" class="link-form">Voltar</a>
        </form>
    </main>

    <?php include "../includes/footer.php"; ?>
</body>

</html>