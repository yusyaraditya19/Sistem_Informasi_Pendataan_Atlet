<?php
session_start();

if (isset($_GET["pilih"])) {
    if ($_GET["pilih"] == "id" || $_GET["pilih"] == "en") {
        $_SESSION["bahasa"] = $_GET["pilih"];
    }
}

$halaman = "index.php";

if (isset($_SERVER["HTTP_REFERER"])) {
    $halaman = $_SERVER["HTTP_REFERER"];
}

header("Location: " . $halaman);
exit;
?>
