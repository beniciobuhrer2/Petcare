<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$id = $_GET['id'] ?? 0;

$sql = "
UPDATE consultas
INNER JOIN animais ON consultas.pet_id = animais.id
SET consultas.status = 'Cancelada'
WHERE consultas.id = $id
AND animais.usuario_id = $usuario_id
AND consultas.status != 'Realizada'
";

mysqli_query($db, $sql);
$_SESSION['mensagem'] = "Consulta cancelada com sucesso!";
header("Location: minhas_consultas.php");
exit;
?>