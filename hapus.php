<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = (int) $_GET["id"];

    $query = $pdo->prepare("DELETE FROM atlet WHERE id_atlet = ?");
    $query->execute([$id]);
}

header("Location: index.php");
exit;
?>
