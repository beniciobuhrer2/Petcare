<?php

require_once "../config/db.php";

$pets = mysqli_query($db, "SELECT id, nome FROM animais ORDER BY nome ASC");

if (isset($_POST['cadastrar'])) {
    $pet_id = $_POST['pet_id'];
    $veterinario = trim($_POST['veterinario']);
    $data_consulta = $_POST['data_consulta'];
    $horario = $_POST['horario'];
    $motivo = trim($_POST['motivo']);
    $observacoes = trim($_POST['observacoes']);

    $sql = "INSERT INTO consultas (pet_id, veterinario, data_consulta, horario, motivo, observacoes)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $pet_id, $veterinario, $data_consulta, $horario, $motivo, $observacoes);
    mysqli_stmt_execute($stmt);

    header("Location: listar.php");
    exit;
}

$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Consulta | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Agendar consulta</h1>

        <label>Pet</label>
        <select name="pet_id" required>
            <option value="">Selecione um pet</option>
            <?php while ($pet = mysqli_fetch_assoc($pets)): ?>
                <option value="<?= $pet['id'] ?>"><?= htmlspecialchars($pet['nome']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Veterinário</label>
        <input type="text" name="veterinario" required>

        <label>Data da consulta</label>
        <input type="date" name="data_consulta" required>

        <label>Horário</label>
        <input type="time" name="horario" required>

        <label>Motivo</label>
        <input type="text" name="motivo" placeholder="Ex: Vacinação, check-up, retorno" required>

        <label>Observações</label>
        <textarea name="observacoes" rows="4"></textarea>

        <button type="submit" name="cadastrar" class="botao botao--primario">Agendar</button>
        <a href="listar.php" class="link-form">Voltar</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
