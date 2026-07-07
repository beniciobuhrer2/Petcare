<?php
require_once "../config/db.php";

$mensagem = "";

if (isset($_POST['cadastrar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if ($nome == "" || $email == "" || $senha == "") {
        $mensagem = "Preencha todos os campos.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senhaHash);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php");
            exit;
        } else {
            $mensagem = "Erro ao cadastrar. Talvez este e-mail já esteja cadastrado.";
        }
    }
}

$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Cadastrar usuário</h1>

        <?php if ($mensagem != ""): ?>
            <p class="mensagem-erro"><?= $mensagem ?></p>
        <?php endif; ?>

        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>E-mail</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit" name="cadastrar" class="botao botao--primario">Cadastrar</button>

        <a href="login.php" class="link-form">Já tenho conta</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
