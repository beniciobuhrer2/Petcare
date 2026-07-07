<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sqlPets = "SELECT * FROM animais WHERE usuario_id = $usuario_id ORDER BY nome";
$resultadoPets = mysqli_query($db, $sqlPets);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST['pet_id'] ?? '';
    $veterinario = "A definir";
    $data_consulta = $_POST['data_consulta'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $motivo = trim($_POST['motivo'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    if (empty($pet_id) || empty($data_consulta) || empty($horario) || empty($motivo)) {

        $erro = "Preencha todos os campos obrigatórios antes de agendar.";

    } else {

        $dataHoraConsulta = strtotime($data_consulta . " " . $horario);
        $dataHoraAgora = time();

        if ($dataHoraConsulta < $dataHoraAgora) {

            $erro = "Não é possível agendar uma consulta em uma data ou horário que já passou.";

        } else {

            $sql = "INSERT INTO consultas 
                    (pet_id, veterinario, data_consulta, horario, motivo, observacoes)
                    VALUES 
                    ('$pet_id', '$veterinario', '$data_consulta', '$horario', '$motivo', '$observacoes')";

            if (mysqli_query($db, $sql)) {
                $_SESSION['mensagem'] = "Consulta agendada com sucesso!";
                header("Location: minhas_consultas.php");
                exit;
            } else {
                $erro = "Erro ao agendar consulta.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Agendar Consulta | PetCare</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<header class="topbar">
    <div class="topbar__marca">
        <a href="painel.php">PetCare</a>
    </div>

    <nav class="topbar__nav">
        <a href="painel.php">Início</a>
        <a href="meus_pets.php">Meus pets</a>
        <a href="minhas_consultas.php">Minhas consultas</a>
        <a href="../usuarios/sair.php" class="botao botao--fantasma">Sair</a>
    </nav>
</header>

<main>
    <div class="form-card">
        <h1>Agendar consulta</h1>
        <p>Escolha um pet e preencha os dados da consulta.</p>

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

        <?php if (mysqli_num_rows($resultadoPets) == 0): ?>

            <p>Você precisa cadastrar um pet antes de agendar uma consulta.</p>
            <a href="cadastrar_pet.php" class="botao botao--primario">Cadastrar pet</a>

        <?php else: ?>

            <form method="POST">
                <label>Pet</label>
                <select name="pet_id">
                    <option value="">Selecione um pet</option>

                    <?php while ($pet = mysqli_fetch_assoc($resultadoPets)): ?>
                        <option value="<?= $pet['id'] ?>" <?= (isset($pet_id) && $pet_id == $pet['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pet['nome']) ?> - <?= htmlspecialchars($pet['especie']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Data da consulta</label>
                <input 
                    type="date" 
                    name="data_consulta" 
                    value="<?= htmlspecialchars($data_consulta ?? '') ?>"
                >

                <label>Horário</label>
                <input 
                    type="time" 
                    name="horario" 
                    value="<?= htmlspecialchars($horario ?? '') ?>"
                >

                <label>Motivo</label>
                <input 
                    type="text" 
                    name="motivo" 
                    placeholder="Ex: Vacinação, check-up, retorno"
                    value="<?= htmlspecialchars($motivo ?? '') ?>"
                >

                <label>Observações</label>
                <textarea 
                    name="observacoes" 
                    rows="4" 
                    placeholder="Digite alguma observação, se necessário"
                ><?= htmlspecialchars($observacoes ?? '') ?></textarea>

                <button type="submit" class="botao botao--primario">Agendar</button>
                <a href="painel.php">Voltar</a>
            </form>

        <?php endif; ?>
    </div>
</main>

<footer class="rodape">
    <p>PetCare © 2026 — Projeto Integrador</p>
</footer>

</body>

</html>