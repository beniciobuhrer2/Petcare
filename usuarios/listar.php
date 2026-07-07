<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$resultado = mysqli_query($db, "SELECT * FROM usuarios ORDER BY id DESC");
$base = "..";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="pagina-crud">
    <div class="cabecalho-crud">
        <div>
            <h1>Usuários</h1>
            <p>Lista de usuários cadastrados no sistema.</p>
        </div>
        <a href="cadastrar.php" class="botao botao--primario">Novo usuário</a>
    </div>

    <table class="tabela">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Criado em</th>
            <th>Ações</th>
        </tr>

        <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= date("d/m/Y H:i", strtotime($usuario['criado_em'])) ?></td>
            <td>
                <a class="acao editar" href="editar.php?id=<?= $usuario['id'] ?>">Editar</a>
                <a class="acao excluir" href="excluir.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Deseja excluir este usuário?')">Excluir</a>
                <a class="acao ver pets" href="pets.php?id=<?= $usuario['id'] ?>">Ver pets</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
