<?php
session_start();

function e($teks) {
    return htmlspecialchars(
        (string) $teks,
        ENT_QUOTES,
        "UTF-8"
    );
}

function wajibLogin() {
    if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
        header("Location: login.php");
        exit;
    }
}

function bahasa() {
    if (isset($_SESSION["bahasa"])) {
        return $_SESSION["bahasa"];
    }

    return "id";
}

function t($id, $en) {
    if (bahasa() == "en") {
        return $en;
    }

    return $id;
}

function nilai($data) {
    if (bahasa() == "en") {
        $terjemahan = [
            "Laki-laki" => "Male",
            "Perempuan" => "Female",
            "Anak-anak" => "Children",
            "Remaja" => "Teenagers",
            "Dewasa" => "Adults",
            "Aktif" => "Active",
            "Tidak Aktif" => "Inactive"
        ];

        if (isset($terjemahan[$data])) {
            return $terjemahan[$data];
        }
    }

    return $data;
}

function awal($judul) {
?>
<!DOCTYPE html>
<html lang="<?= e(bahasa()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul) ?> | AthleteHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <a class="brand" href="index.php">AthleteHub</a>

        <p class="nav-title">
            <?= e(t("MENU UTAMA", "MAIN MENU")) ?>
        </p>

        <a class="nav-link" href="index.php">
            <?= e(t("Dashboard", "Dashboard")) ?>
        </a>

        <a class="nav-link" href="tambah.php">
            <?= e(t("Tambah Atlet", "Add Athlete")) ?>
        </a>

        <div class="sidebar-bottom">
            <a class="nav-link" href="logout.php">
                <?= e(t("Keluar", "Log out")) ?>
            </a>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <small>
                    <?= e(t("SISTEM INFORMASI UKM", "SPORTS CLUB INFORMATION SYSTEM")) ?>
                </small>
                <h1><?= e($judul) ?></h1>
            </div>

            <div class="lang">
                <a href="bahasa.php?pilih=id">ID</a>
                <a href="bahasa.php?pilih=en">EN</a>
            </div>
        </header>

        <div class="content">
<?php
}

function akhir() {
?>
        </div>

        <footer class="footer">
            AthleteHub - UKM Multi-Cabang Olahraga
        </footer>
    </main>
</div>

</body>
</html>
<?php
}
?>
