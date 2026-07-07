<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

if (!$usuario) {
    die("Usuário não encontrado.");
}

if (isset($_POST['salvar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if ($senha != "") {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmtUpdate = mysqli_prepare($db, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "sssi", $nome, $email, $senhaHash, $id);
    } else {
        $sqlUpdate = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmtUpdate = mysqli_prepare($db, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ssi", $nome, $email, $id);
    }

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
    <title>Editar Usuário | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Editar usuário</h1>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label>Nova senha</label>
        <input type="password" name="senha" placeholder="Deixe vazio para manter">

        <button type="submit" name="salvar" class="botao botao--primario">Salvar</button>
        <a href="listar.php" class="link-form">Voltar</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
