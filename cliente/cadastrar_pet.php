<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$dono_nome = $_SESSION['usuario_nome'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome']);
    $especie = trim($_POST['especie']);
    $raca = trim($_POST['raca']);
    $idade = $_POST['idade'];

    if (empty($nome) || empty($especie) || empty($raca) || $idade === '') {

        $erro = "Preencha todos os campos antes de cadastrar o pet.";

    } else {

        $sql = "INSERT INTO animais 
                (nome, especie, raca, idade, dono_nome, usuario_id)
                VALUES 
                ('$nome', '$especie', '$raca', '$idade', '$dono_nome', '$usuario_id')";

        if (mysqli_query($db, $sql)) {

            $_SESSION['mensagem'] = "Pet cadastrado com sucesso!";

            header("Location: meus_pets.php");
            exit;

        } else {

            $erro = "Erro ao cadastrar pet.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pet | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <header class="topbar">

        <div class="topbar__marca">
            <a href="painel.php">PetCare</a>
        </div>

        <nav class="topbar__nav">

            <a href="painel.php">Início</a>

            <a href="meus_pets.php">
                Meus pets
            </a>

            <a href="agendar_consulta.php">
                Agendar consulta
            </a>

            <a href="minhas_consultas.php">
                Minhas consultas
            </a>

            <a href="../usuarios/sair.php" class="botao botao--fantasma">
                Sair
            </a>

        </nav>

    </header>

    <main>

        <div class="form-card">

            <h1>Cadastrar pet</h1>

            <?php if (isset($erro)) { ?>

                <div style="
                    background-color: #f8d7da;
                    color: #721c24;
                    border: 1px solid #f5c6cb;
                    padding: 14px 18px;
                    border-radius: 12px;
                    font-weight: 700;
                    margin: 18px 0;
                ">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php } ?>

            <form method="POST">

                <label>Nome do pet</label>

                <input
                    type="text"
                    name="nome"
                    value="<?= htmlspecialchars($nome ?? '') ?>"
                >

                <label>Espécie</label>

                <input
                    type="text"
                    name="especie"
                    placeholder="Ex: Cachorro, Gato, Coelho"
                    value="<?= htmlspecialchars($especie ?? '') ?>"
                >

                <label>Raça</label>

                <input
                    type="text"
                    name="raca"
                    value="<?= htmlspecialchars($raca ?? '') ?>"
                >

                <label>Idade</label>

                <input
                    type="number"
                    name="idade"
                    min="0"
                    value="<?= htmlspecialchars($idade ?? '') ?>"
                >

                <button
                    type="submit"
                    class="botao botao--primario"
                >
                    Cadastrar
                </button>

                <a href="painel.php">
                    Voltar
                </a>

            </form>

        </div>

    </main>

    <footer class="rodape">

        <p>
            PetCare © 2026 — Projeto Integrador
        </p>

    </footer>

</body>

</html>