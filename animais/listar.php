<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$resultado = mysqli_query($db, "SELECT * FROM animais ORDER BY id DESC");
$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pets | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-crud">
    <div class="cabecalho-crud">
        <div>
            <h1>Pets</h1>
            <p>Cadastre e gerencie os animais da clínica.</p>
        </div>
        <a href="cadastrar.php" class="botao botao--primario">Novo pet</a>
    </div>

    <table class="tabela">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Idade</th>
            <th>Dono</th>
            <th>Ações</th>
        </tr>

        <?php while ($animal = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $animal['id'] ?></td>
            <td><?= htmlspecialchars($animal['nome']) ?></td>
            <td><?= htmlspecialchars($animal['especie']) ?></td>
            <td><?= htmlspecialchars($animal['raca']) ?></td>
            <td><?= htmlspecialchars($animal['idade']) ?></td>
            <td><?= htmlspecialchars($animal['dono_nome']) ?></td>
            <td>
                <a class="acao editar" href="editar.php?id=<?= $animal['id'] ?>">Editar</a>
                <a class="acao excluir" href="excluir.php?id=<?= $animal['id'] ?>" onclick="return confirm('Deseja excluir este pet?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
