<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM animais WHERE id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$animal = mysqli_fetch_assoc($resultado);

if (!$animal) {
    die("Pet não encontrado.");
}

if (isset($_POST['salvar'])) {
    $nome = trim($_POST['nome']);
    $especie = trim($_POST['especie']);
    $raca = trim($_POST['raca']);
    $idade = $_POST['idade'];
    $dono_nome = trim($_POST['dono_nome']);

    $sqlUpdate = "UPDATE animais SET nome = ?, especie = ?, raca = ?, idade = ?, dono_nome = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($db, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "sssisi", $nome, $especie, $raca, $idade, $dono_nome, $id);
    mysqli_stmt_execute($stmtUpdate);

    header("Location: listar.php");
    exit;
}

$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pet | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Editar pet</h1>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($animal['nome']) ?>" required>

        <label>Espécie</label>
        <input type="text" name="especie" value="<?= htmlspecialchars($animal['especie']) ?>" required>

        <label>Raça</label>
        <input type="text" name="raca" value="<?= htmlspecialchars($animal['raca']) ?>">

        <label>Idade</label>
        <input type="number" name="idade" min="0" value="<?= htmlspecialchars($animal['idade']) ?>">

        <label>Nome do dono</label>
        <input type="text" name="dono_nome" value="<?= htmlspecialchars($animal['dono_nome']) ?>" required>

        <button type="submit" name="salvar" class="botao botao--primario">Salvar</button>
        <a href="listar.php" class="link-form">Voltar</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
