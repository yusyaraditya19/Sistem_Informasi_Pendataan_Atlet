<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$bahasa = isset($_SESSION["bahasa"]) ? $_SESSION["bahasa"] : "id";

$query = $pdo->query("
    SELECT cabang_olahraga, COUNT(*) AS jumlah_atlet
    FROM atlet
    GROUP BY cabang_olahraga
    ORDER BY cabang_olahraga ASC
");

$data_cabang = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?php echo $bahasa; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $bahasa == "en" ? "Sports" : "Cabang Olahraga"; ?>
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

        <a class="nav-link" href="index.php">Dashboard</a>

        <a class="nav-link" href="tambah.php">
            <?php echo $bahasa == "en" ? "Add Athlete" : "Tambah Atlet"; ?>
        </a>

        <a class="nav-link active" href="cabang.php">
            <?php echo $bahasa == "en" ? "Sports" : "Cabang Olahraga"; ?>
        </a>

        <a class="nav-link" href="laporan.php">
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
                    <?php echo $bahasa == "en" ? "Sports" : "Cabang Olahraga"; ?>
                </h1>

                <p>
                    <?php
                    echo $bahasa == "en"
                        ? "List of sports and registered athletes."
                        : "Daftar cabang olahraga dan jumlah atlet terdaftar.";
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

            <section class="table-card">

                <div class="table-heading">
                    <div>
                        <h2>
                            <?php
                            echo $bahasa == "en"
                                ? "Sports List"
                                : "Daftar Cabang Olahraga";
                            ?>
                        </h2>

                        <p>
                            <?php
                            echo $bahasa == "en"
                                ? "Number of athletes registered in each sport."
                                : "Jumlah atlet yang terdaftar pada setiap cabang.";
                            ?>
                        </p>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>
                                    <?php
                                    echo $bahasa == "en"
                                        ? "Sport"
                                        : "Cabang Olahraga";
                                    ?>
                                </th>
                                <th>
                                    <?php
                                    echo $bahasa == "en"
                                        ? "Number of Athletes"
                                        : "Jumlah Atlet";
                                    ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($data_cabang) > 0) { ?>
                                <?php $no = 1; ?>

                                <?php foreach ($data_cabang as $cabang) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $cabang["cabang_olahraga"]
                                            );
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo $cabang["jumlah_atlet"]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="empty-data">
                                        <?php
                                        echo $bahasa == "en"
                                            ? "No sports data available."
                                            : "Belum ada data cabang olahraga.";
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
