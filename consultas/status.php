<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../cliente/painel.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$status = $_GET['status'];
if ($status == 'Confirmada') {
    $sqlConsulta = "SELECT veterinario FROM consultas WHERE id = $id";
    $resultadoConsulta = mysqli_query($db, $sqlConsulta);
    $consulta = mysqli_fetch_assoc($resultadoConsulta);

    if ($consulta['veterinario'] == 'A definir') {
        header("Location: listar.php?erro=veterinario");
        exit;
    }
}
$sql = "UPDATE consultas SET status = '$status' WHERE id = $id";

mysqli_query($db, $sql);

header("Location: listar.php");
exit;
