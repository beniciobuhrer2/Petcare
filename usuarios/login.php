<?php
session_start();
require_once "../config/db.php";

$mensagem = "";

if (isset($_POST['entrar'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

    if ($usuario['tipo'] == 'admin') {
             header("Location: ../index.php");
    } else {
    header("Location: ../cliente/painel.php");
}
        exit;
    } else {
        $mensagem = "E-mail ou senha incorretos.";
    }
}

$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Entrar</h1>

        <?php if ($mensagem != ""): ?>
            <p class="mensagem-erro"><?= $mensagem ?></p>
        <?php endif; ?>

        <label>E-mail</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit" name="entrar" class="botao botao--primario">Fazer login</button>

        <a href="cadastrar.php" class="link-form">Criar conta</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
