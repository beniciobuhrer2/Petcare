<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../config/db.php";

$id = $_GET['id'] ?? 0;

$sql = "DELETE FROM animais WHERE id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: listar.php");
exit;
?>
