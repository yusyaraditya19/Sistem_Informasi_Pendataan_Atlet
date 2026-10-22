<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$bahasa = isset($_SESSION["bahasa"]) ? $_SESSION["bahasa"] : "id";

$query_total = $pdo->query("SELECT COUNT(*) AS total FROM atlet");
$total_atlet = $query_total->fetch(PDO::FETCH_ASSOC)["total"];

$query_aktif = $pdo->query("
    SELECT COUNT(*) AS total
    FROM atlet
    WHERE status = 'Aktif'
");
$total_aktif = $query_aktif->fetch(PDO::FETCH_ASSOC)["total"];

$query_nonaktif = $pdo->query("
    SELECT COUNT(*) AS total
    FROM atlet
    WHERE status = 'Tidak Aktif'
");
$total_nonaktif = $query_nonaktif->fetch(PDO::FETCH_ASSOC)["total"];

$query_cabang = $pdo->query("
    SELECT cabang_olahraga, COUNT(*) AS jumlah
    FROM atlet
    GROUP BY cabang_olahraga
    ORDER BY cabang_olahraga ASC
");
$data_cabang = $query_cabang->fetchAll(PDO::FETCH_ASSOC);

$query_gender = $pdo->query("
    SELECT jenis_kelamin, COUNT(*) AS jumlah
    FROM atlet
    GROUP BY jenis_kelamin
    ORDER BY jenis_kelamin ASC
");
$data_gender = $query_gender->fetchAll(PDO::FETCH_ASSOC);

$query_kategori = $pdo->query("
    SELECT kategori, COUNT(*) AS jumlah
    FROM atlet
    GROUP BY kategori
    ORDER BY kategori ASC
");
$data_kategori = $query_kategori->fetchAll(PDO::FETCH_ASSOC);

$query_tahun = $pdo->query("
    SELECT tahun_bergabung, COUNT(*) AS jumlah
    FROM atlet
    GROUP BY tahun_bergabung
    ORDER BY tahun_bergabung ASC
");
$data_tahun = $query_tahun->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?php echo $bahasa; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $bahasa == "en" ? "Reports" : "Laporan Data"; ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <div class="brand">AthleteHub</div>

        <p class="sidebar-caption">
            <?php
            echo $bahasa == "en"
                ? "ATHLETE INFORMATION SYSTEM"
                : "SISTEM INFORMASI ATLET";
            ?>
        </p>

        <a class="nav-link" href="index.php">
            <?php echo $bahasa == "en" ? "Dashboard" : "Dashboard"; ?>
        </a>

        <a class="nav-link" href="tambah.php">
            <?php echo $bahasa == "en" ? "Add Athlete" : "Tambah Atlet"; ?>
        </a>

        <a class="nav-link" href="cabang.php">
            <?php echo $bahasa == "en" ? "Sports" : "Cabang Olahraga"; ?>
        </a>

        <a class="nav-link active" href="laporan.php">
            <?php echo $bahasa == "en" ? "Reports" : "Laporan Data"; ?>
        </a>

        <div class="sidebar-bottom">
            <a class="nav-link" href="logout.php">
                <?php echo $bahasa == "en" ? "Logout" : "Keluar"; ?>
            </a>
        </div>
    </aside>

    <main class="main">

        <header class="topbar">
            <div class="topbar-title">
                <h1>
                    <?php echo $bahasa == "en" ? "Reports" : "Laporan Data"; ?>
                </h1>

                <p>
                    <?php
                    echo $bahasa == "en"
                        ? "Summary and distribution of athlete data."
                        : "Ringkasan dan persebaran data atlet.";
                    ?>
                </p>
            </div>

            <div class="language-switch">
                <span>
                    <?php echo $bahasa == "en" ? "Language:" : "Bahasa:"; ?>
                </span>

                <a href="bahasa.php?pilih=id">Indonesia</a>
                <a href="bahasa.php?pilih=en">English</a>
            </div>
        </header>

        <div class="content">

            <div class="summary-grid">

                <div class="summary-card">
                    <p>
                        <?php echo $bahasa == "en" ? "Total Athletes" : "Total Atlet"; ?>
                    </p>
                    <h2><?php echo $total_atlet; ?></h2>
                </div>

                <div class="summary-card">
                    <p>
                        <?php echo $bahasa == "en" ? "Active Athletes" : "Atlet Aktif"; ?>
                    </p>
                    <h2><?php echo $total_aktif; ?></h2>
                </div>

                <div class="summary-card">
                    <p>
                        <?php echo $bahasa == "en" ? "Inactive Athletes" : "Atlet Tidak Aktif"; ?>
                    </p>
                    <h2><?php echo $total_nonaktif; ?></h2>
                </div>

                <div class="summary-card">
                    <p>
                        <?php echo $bahasa == "en" ? "Sports" : "Cabang Olahraga"; ?>
                    </p>
                    <h2><?php echo count($data_cabang); ?></h2>
                </div>

            </div>

            <!-- Laporan berdasarkan cabang olahraga -->
            <section class="table-card">
                <div class="table-heading">
                    <div>
                        <h2>
                            <?php
                            echo $bahasa == "en"
                                ? "Athletes by Sport"
                                : "Jumlah Atlet per Cabang";
                            ?>
                        </h2>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Sport" : "Cabang Olahraga"; ?>
                                </th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Number of Athletes" : "Jumlah Atlet"; ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($data_cabang) > 0) { ?>
                                <?php $no = 1; ?>

                                <?php foreach ($data_cabang as $baris) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <?php
                                            echo htmlspecialchars($baris["cabang_olahraga"]);
                                            ?>
                                        </td>
                                        <td><?php echo $baris["jumlah"]; ?></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="empty-data">
                                        <?php
                                        echo $bahasa == "en"
                                            ? "No data available."
                                            : "Belum ada data.";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Laporan berdasarkan jenis kelamin -->
            <section class="table-card">
                <div class="table-heading">
                    <div>
                        <h2>
                            <?php
                            echo $bahasa == "en"
                                ? "Athletes by Gender"
                                : "Jumlah Atlet berdasarkan Jenis Kelamin";
                            ?>
                        </h2>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Gender" : "Jenis Kelamin"; ?>
                                </th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Total" : "Jumlah"; ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($data_gender) > 0) { ?>
                                <?php $no = 1; ?>

                                <?php foreach ($data_gender as $baris) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <?php
                                            if ($bahasa == "en") {
                                                if ($baris["jenis_kelamin"] == "Laki-laki") {
                                                    echo "Male";
                                                } elseif ($baris["jenis_kelamin"] == "Perempuan") {
                                                    echo "Female";
                                                } else {
                                                    echo htmlspecialchars($baris["jenis_kelamin"]);
                                                }
                                            } else {
                                                echo htmlspecialchars($baris["jenis_kelamin"]);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $baris["jumlah"]; ?></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="empty-data">
                                        <?php
                                        echo $bahasa == "en"
                                            ? "No data available."
                                            : "Belum ada data.";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Laporan berdasarkan kategori -->
            <section class="table-card">
                <div class="table-heading">
                    <div>
                        <h2>
                            <?php
                            echo $bahasa == "en"
                                ? "Athletes by Category"
                                : "Jumlah Atlet berdasarkan Kategori";
                            ?>
                        </h2>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Category" : "Kategori"; ?>
                                </th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Total" : "Jumlah"; ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($data_kategori) > 0) { ?>
                                <?php $no = 1; ?>

                                <?php foreach ($data_kategori as $baris) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <?php
                                            if ($bahasa == "en") {
                                                if ($baris["kategori"] == "Remaja") {
                                                    echo "Teenager";
                                                } elseif ($baris["kategori"] == "Dewasa") {
                                                    echo "Adult";
                                                } else {
                                                    echo htmlspecialchars($baris["kategori"]);
                                                }
                                            } else {
                                                echo htmlspecialchars($baris["kategori"]);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $baris["jumlah"]; ?></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="empty-data">
                                        <?php
                                        echo $bahasa == "en"
                                            ? "No data available."
                                            : "Belum ada data.";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Laporan berdasarkan tahun bergabung -->
            <section class="table-card">
                <div class="table-heading">
                    <div>
                        <h2>
                            <?php
                            echo $bahasa == "en"
                                ? "Athletes by Joining Year"
                                : "Jumlah Atlet berdasarkan Tahun Bergabung";
                            ?>
                        </h2>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Joining Year" : "Tahun Bergabung"; ?>
                                </th>
                                <th>
                                    <?php echo $bahasa == "en" ? "Total" : "Jumlah"; ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($data_tahun) > 0) { ?>
                                <?php $no = 1; ?>

                                <?php foreach ($data_tahun as $baris) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <?php
                                            echo htmlspecialchars((string) $baris["tahun_bergabung"]);
                                            ?>
                                        </td>
                                        <td><?php echo $baris["jumlah"]; ?></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="empty-data">
                                        <?php
                                        echo $bahasa == "en"
                                            ? "No data available."
                                            : "Belum ada data.";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </main>

</div>

</body>
</html>
