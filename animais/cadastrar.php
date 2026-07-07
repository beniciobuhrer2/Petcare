<?php
require_once "../config/db.php";

if (isset($_POST['cadastrar'])) {
    $nome = trim($_POST['nome']);
    $especie = trim($_POST['especie']);
    $raca = trim($_POST['raca']);
    $idade = $_POST['idade'];
    $dono_nome = trim($_POST['dono_nome']);

    $sql = "INSERT INTO animais (nome, especie, raca, idade, dono_nome) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "sssis", $nome, $especie, $raca, $idade, $dono_nome);
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
    <title>Cadastrar Pet | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-form">
    <form method="POST" class="formulario">
        <h1>Cadastrar pet</h1>

        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>Espécie</label>
        <input type="text" name="especie" placeholder="Ex: Cachorro, Gato, Coelho" required>

        <label>Raça</label>
        <input type="text" name="raca">

        <label>Idade</label>
        <input type="number" name="idade" min="0">

        <label>Nome do dono</label>
        <input type="text" name="dono_nome" required>

        <button type="submit" name="cadastrar" class="botao botao--primario">Cadastrar</button>
        <a href="listar.php" class="link-form">Voltar</a>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
