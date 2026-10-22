<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$bahasa = "id";

if (isset($_SESSION["bahasa"])) {
    $bahasa = $_SESSION["bahasa"];
}

if ($bahasa == "en") {
    $judul = "Athlete Dashboard";
    $sambutan = "Welcome, admin";
    $totalAtlet = "Total Athletes";
    $atletAktif = "Active Athletes";
    $daftarAtlet = "Athlete List";
    $deskripsi = "Athlete data from various sports.";
    $tambahAtlet = "Add Athlete";
    $nomor = "No.";
    $nama = "Name";
    $jenisKelamin = "Gender";
    $cabang = "Sport";
    $kategori = "Category";
    $status = "Status";
    $aksi = "Action";
    $edit = "Edit";
    $hapus = "Delete";
    $aktif = "Active";
    $tidakAktif = "Inactive";
    $dashboard = "Dashboard";
    $keluar = "Logout";
    $bahasaLabel = "Language";
    $dataKosong = "No athlete data available.";
    $konfirmasiHapus = "Are you sure you want to delete this athlete?";
    $teksCari = "Search name, sport, category, or status...";
    $tombolCari = "Search";
    $tombolReset = "Reset";
    $hasilCari = "Search results for";
    $footer = "AthleteHub — Student Sports Club Athlete Information System";
} else {
    $judul = "Dashboard Atlet";
    $sambutan = "Selamat datang, admin";
    $totalAtlet = "Total Atlet";
    $atletAktif = "Atlet Aktif";
    $daftarAtlet = "Daftar Atlet";
    $deskripsi = "Data anggota atlet berbagai cabang olahraga.";
    $tambahAtlet = "Tambah Atlet";
    $nomor = "No.";
    $nama = "Nama";
    $jenisKelamin = "Jenis Kelamin";
    $cabang = "Cabang Olahraga";
    $kategori = "Kategori";
    $status = "Status";
    $aksi = "Aksi";
    $edit = "Edit";
    $hapus = "Hapus";
    $aktif = "Aktif";
    $tidakAktif = "Tidak Aktif";
    $dashboard = "Dashboard";
    $keluar = "Keluar";
    $bahasaLabel = "Bahasa";
    $dataKosong = "Belum ada data atlet.";
    $konfirmasiHapus = "Yakin ingin menghapus data atlet ini?";
    $teksCari = "Cari nama, cabang olahraga, kategori, atau status...";
    $tombolCari = "Cari";
    $tombolReset = "Reset";
    $hasilCari = "Hasil pencarian untuk";
    $footer = "AthleteHub — Sistem Informasi Pendataan Atlet UKM";
}

/* Mengambil kata pencarian */
$cari = "";

if (isset($_GET["cari"])) {
    $cari = trim($_GET["cari"]);
}

/* Mengambil data atlet berdasarkan pencarian */
if ($cari != "") {
    $sql = "SELECT * FROM atlet
            WHERE nama_atlet LIKE ?
            OR cabang_olahraga LIKE ?
            OR kategori LIKE ?
            OR status LIKE ?
            ORDER BY id_atlet ASC";

    $query = $pdo->prepare($sql);

    $kataCari = "%" . $cari . "%";

    $query->execute([
        $kataCari,
        $kataCari,
        $kataCari,
        $kataCari
    ]);
} else {
    $query = $pdo->query(
        "SELECT * FROM atlet ORDER BY id_atlet ASC"
    );
}

$dataAtletList = $query->fetchAll(PDO::FETCH_ASSOC);

/* Menghitung total atlet */
$queryTotal = $pdo->query(
    "SELECT COUNT(*) FROM atlet"
);
$total = $queryTotal->fetchColumn();

/* Menghitung atlet aktif */
$queryAktif = $pdo->prepare(
    "SELECT COUNT(*) FROM atlet WHERE status = ?"
);
$queryAktif->execute(["Aktif"]);
$totalAktif = $queryAktif->fetchColumn();
?>

<!DOCTYPE html>
<html lang="<?php echo $bahasa; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $judul; ?> - AthleteHub</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="layout">

    <!-- Sidebar -->
    
	<aside class="sidebar">

		<div class="brand">AthleteHub</div>

		<p class="sidebar-caption">
			<?php
			echo $bahasa == "en"
				? "ATHLETE INFORMATION SYSTEM"
				: "SISTEM INFORMASI ATLET";
			?>
		</p>

		<a class="nav-link active" href="index.php">
			<?php echo $bahasa == "en" ? "Dashboard" : "Dashboard"; ?>
		</a>

		<a class="nav-link" href="tambah.php">
			<?php echo $bahasa == "en" ? "Add Athlete" : "Tambah Atlet"; ?>
		</a>

		<a class="nav-link" href="cabang.php">
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


    <!-- Konten utama -->
    <main class="main">

        <!-- Header -->
        <header class="topbar">

            <div class="topbar-title">
                <h1><?php echo $judul; ?></h1>
                <p><?php echo $sambutan; ?></p>
            </div>

            <!-- Pilihan bahasa hanya di kanan atas -->
            <div class="language-switch">

                <span><?php echo $bahasaLabel; ?>:</span>

                <a href="bahasa.php?pilih=id">Indonesia</a>

                <a href="bahasa.php?pilih=en">English</a>

            </div>

        </header>

        <section class="content">

            <!-- Ringkasan -->
            <div class="summary-grid">

                <div class="summary-card">
                    <p><?php echo $totalAtlet; ?></p>
                    <h2><?php echo $total; ?></h2>
                </div>

                <div class="summary-card">
                    <p><?php echo $atletAktif; ?></p>
                    <h2><?php echo $totalAktif; ?></h2>
                </div>

            </div>

            <!-- Panel pencarian terpisah -->
            <div class="search-card">

                <form method="GET" action="index.php" class="search-form">

                    <input
                        type="text"
                        name="cari"
                        placeholder="<?php echo $teksCari; ?>"
                        value="<?php echo htmlspecialchars($cari); ?>"
                    >

                    <button type="submit" class="button">
                        <?php echo $tombolCari; ?>
                    </button>

                    <?php if ($cari != "") { ?>
                        <a class="button-secondary" href="index.php">
                            <?php echo $tombolReset; ?>
                        </a>
                    <?php } ?>

                </form>

            </div>

            <!-- Panel tabel atlet -->
            <div class="table-card" id="daftar-atlet">

                <div class="table-heading">

                    <div>
                        <h2><?php echo $daftarAtlet; ?></h2>
                        <p><?php echo $deskripsi; ?></p>
                    </div>

                    <a class="button" href="tambah.php">
                        <?php echo $tambahAtlet; ?>
                    </a>

                </div>

                <?php if ($cari != "") { ?>
                    <p class="search-result">
                        <?php echo $hasilCari; ?>:
                        <strong><?php echo htmlspecialchars($cari); ?></strong>
                    </p>
                <?php } ?>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th><?php echo $nomor; ?></th>
                                <th><?php echo $nama; ?></th>
                                <th><?php echo $jenisKelamin; ?></th>
                                <th><?php echo $cabang; ?></th>
                                <th><?php echo $kategori; ?></th>
                                <th><?php echo $status; ?></th>
                                <th><?php echo $aksi; ?></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($dataAtletList) > 0) { ?>

                                <?php $no = 1; ?>

                                <?php foreach ($dataAtletList as $atlet) { ?>

                                    <tr>

                                        <td><?php echo $no++; ?></td>

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $atlet["nama_atlet"]
                                            );
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($bahasa == "en") {
                                                if ($atlet["jenis_kelamin"] == "Laki-laki") {
                                                    echo "Male";
                                                } elseif ($atlet["jenis_kelamin"] == "Perempuan") {
                                                    echo "Female";
                                                }
                                            } else {
                                                echo htmlspecialchars(
                                                    $atlet["jenis_kelamin"]
                                                );
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if (
                                                $bahasa == "en" &&
                                                $atlet["cabang_olahraga"] == "Lainnya"
                                            ) {
                                                echo "Other";
                                            } else {
                                                echo htmlspecialchars(
                                                    $atlet["cabang_olahraga"]
                                                );
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($bahasa == "en") {
                                                if ($atlet["kategori"] == "Remaja") {
                                                    echo "Teenager";
                                                } elseif ($atlet["kategori"] == "Dewasa") {
                                                    echo "Adult";
                                                } else {
                                                    echo htmlspecialchars(
                                                        $atlet["kategori"]
                                                    );
                                                }
                                            } else {
                                                echo htmlspecialchars(
                                                    $atlet["kategori"]
                                                );
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php if ($atlet["status"] == "Aktif") { ?>

                                                <span class="status-active">
                                                    <?php echo $aktif; ?>
                                                </span>

                                            <?php } else { ?>

                                                <span class="status-inactive">
                                                    <?php echo $tidakAktif; ?>
                                                </span>

                                            <?php } ?>
                                        </td>

                                        <td class="action-cell">

                                            <a
                                                class="button-small"
                                                href="edit.php?id=<?php echo $atlet['id_atlet']; ?>"
                                            >
                                                <?php echo $edit; ?>
                                            </a>

                                            <a
                                                class="button-small button-delete"
                                                href="hapus.php?id=<?php echo $atlet['id_atlet']; ?>"
                                                onclick="return confirm('<?php echo $konfirmasiHapus; ?>')"
                                            >
                                                <?php echo $hapus; ?>
                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="7" class="empty-data">
                                        <?php echo $dataKosong; ?>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>
