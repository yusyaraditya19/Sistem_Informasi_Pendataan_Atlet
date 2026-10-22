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
    $judul = "Add Athlete";
    $deskripsi = "Enter information for a new athlete.";
    $informasi = "Athlete Information";
    $nama = "Athlete Name";
    $jk = "Gender";
    $tanggal = "Date of Birth";
    $cabang = "Sport";
    $telepon = "Phone Number";
    $kategori = "Category";
    $tahun = "Year Joined";
    $status = "Status";
    $pilihJK = "Select gender";
    $pilihCabang = "Select sport";
    $pilihKategori = "Select category";
    $pilihStatus = "Select status";
    $remaja = "Teenager";
    $dewasa = "Adult";
    $aktif = "Active";
    $tidakAktif = "Inactive";
    $batal = "Cancel";
    $simpan = "Save Athlete";
    $dashboard = "Dashboard";
    $keluar = "Logout";
    $bahasaLabel = "Language";
    $pesanKosong = "All fields are required.";
    $pesanTahun = "Invalid joining year.";
    $pesanTelepon = "Invalid phone number.";
    $pesanTanggal = "Invalid date of birth.";
} else {
    $judul = "Tambah Atlet";
    $deskripsi = "Masukkan informasi atlet baru.";
    $informasi = "Informasi Atlet";
    $nama = "Nama Atlet";
    $jk = "Jenis Kelamin";
    $tanggal = "Tanggal Lahir";
    $cabang = "Cabang Olahraga";
    $telepon = "Nomor Telepon";
    $kategori = "Kategori";
    $tahun = "Tahun Bergabung";
    $status = "Status";
    $pilihJK = "Pilih jenis kelamin";
    $pilihCabang = "Pilih cabang olahraga";
    $pilihKategori = "Pilih kategori";
    $pilihStatus = "Pilih status";
    $remaja = "Remaja";
    $dewasa = "Dewasa";
    $aktif = "Aktif";
    $tidakAktif = "Tidak Aktif";
    $batal = "Batal";
    $simpan = "Simpan Atlet";
    $dashboard = "Dashboard";
    $keluar = "Keluar";
    $bahasaLabel = "Bahasa";
    $pesanKosong = "Semua kolom wajib diisi.";
    $pesanTahun = "Tahun bergabung tidak valid.";
    $pesanTelepon = "Nomor telepon tidak valid.";
    $pesanTanggal = "Tanggal lahir tidak valid.";
}

$pesan = "";

$namaAtlet = "";
$jenisKelamin = "";
$tanggalLahir = "";
$cabangOlahraga = "";
$nomorTelepon = "";
$kategoriAtlet = "";
$tahunBergabung = "";
$statusAtlet = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaAtlet = trim($_POST["nama_atlet"] ?? "");
    $jenisKelamin = $_POST["jenis_kelamin"] ?? "";
    $tanggalLahir = $_POST["tanggal_lahir"] ?? "";
    $cabangOlahraga = $_POST["cabang_olahraga"] ?? "";
    $nomorTelepon = trim($_POST["nomor_telepon"] ?? "");
    $kategoriAtlet = $_POST["kategori"] ?? "";
    $tahunBergabung = $_POST["tahun_bergabung"] ?? "";
    $statusAtlet = $_POST["status"] ?? "";

    if (
        $namaAtlet == "" ||
        $jenisKelamin == "" ||
        $tanggalLahir == "" ||
        $cabangOlahraga == "" ||
        $nomorTelepon == "" ||
        $kategoriAtlet == "" ||
        $tahunBergabung == "" ||
        $statusAtlet == ""
    ) {
        $pesan = $pesanKosong;
    } elseif (
        !is_numeric($tahunBergabung) ||
        $tahunBergabung < 1900 ||
        $tahunBergabung > date("Y")
    ) {
        $pesan = $pesanTahun;
    } elseif (!preg_match("/^[0-9+ -]+$/", $nomorTelepon)) {
        $pesan = $pesanTelepon;
    } elseif (
        !in_array($jenisKelamin, ["Laki-laki", "Perempuan"]) ||
        !in_array($kategoriAtlet, ["Remaja", "Dewasa"]) ||
        !in_array($statusAtlet, ["Aktif", "Tidak Aktif"]) ||
        !in_array($cabangOlahraga, [
            "Taekwondo",
            "Badminton",
            "Basket",
            "Futsal",
            "Voli",
            "Pencak Silat",
            "Karate",
            "Lainnya"
        ])
    ) {
        $pesan = $bahasa == "en"
            ? "Invalid selection."
            : "Pilihan data tidak valid.";
    } else {
        $tanggalObjek = DateTime::createFromFormat(
            "!Y-m-d",
            $tanggalLahir
        );

        if (
            !$tanggalObjek ||
            $tanggalObjek->format("Y-m-d") != $tanggalLahir ||
            $tanggalLahir > date("Y-m-d")
        ) {
            $pesan = $pesanTanggal;
        } else {
            $sql = "INSERT INTO atlet
                    (
                        nama_atlet,
                        jenis_kelamin,
                        tanggal_lahir,
                        cabang_olahraga,
                        nomor_telepon,
                        kategori,
                        tahun_bergabung,
                        status
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $query = $pdo->prepare($sql);

            $query->execute([
                $namaAtlet,
                $jenisKelamin,
                $tanggalLahir,
                $cabangOlahraga,
                $nomorTelepon,
                $kategoriAtlet,
                $tahunBergabung,
                $statusAtlet
            ]);

            header("Location: index.php");
            exit;
        }
    }
}

$cabangPilihan = [
    "Taekwondo",
    "Badminton",
    "Basket",
    "Futsal",
    "Voli",
    "Pencak Silat",
    "Karate",
    "Lainnya"
];
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
            <?php echo $dashboard; ?>
        </a>

        <a class="nav-link active" href="tambah.php">
            <?php echo $judul; ?>
        </a>

        <a class="nav-link" href="cabang.php">
            <?php
            echo $bahasa == "en"
                ? "Sports"
                : "Cabang Olahraga";
            ?>
        </a>

        <a class="nav-link" href="laporan.php">
            <?php
            echo $bahasa == "en"
                ? "Reports"
                : "Laporan Data";
            ?>
        </a>

        <div class="sidebar-bottom">
            <a class="nav-link" href="logout.php">
                <?php echo $keluar; ?>
            </a>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">

            <div class="topbar-title">
                <h1><?php echo $judul; ?></h1>
                <p><?php echo $deskripsi; ?></p>
            </div>

            <div class="language-switch">
                <span><?php echo $bahasaLabel; ?>:</span>
                <a href="bahasa.php?pilih=id">Indonesia</a>
                <a href="bahasa.php?pilih=en">English</a>
            </div>

        </header>

        <section class="content">

            <div class="form-card">

                <h2><?php echo $informasi; ?></h2>

                <?php if ($pesan != "") { ?>
                    <p class="error">
                        <?php echo htmlspecialchars($pesan); ?>
                    </p>
                <?php } ?>

                <form method="POST">

                    <div class="form-grid">

                        <div class="form-group">
                            <label><?php echo $nama; ?></label>

                            <input
                                type="text"
                                name="nama_atlet"
                                maxlength="100"
                                value="<?php echo htmlspecialchars($namaAtlet); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label><?php echo $jk; ?></label>

                            <select name="jenis_kelamin" required>
                                <option value="">
                                    <?php echo $pilihJK; ?>
                                </option>

                                <option
                                    value="Laki-laki"
                                    <?php if ($jenisKelamin == "Laki-laki") echo "selected"; ?>
                                >
                                    <?php
                                    echo $bahasa == "en"
                                        ? "Male"
                                        : "Laki-laki";
                                    ?>
                                </option>

                                <option
                                    value="Perempuan"
                                    <?php if ($jenisKelamin == "Perempuan") echo "selected"; ?>
                                >
                                    <?php
                                    echo $bahasa == "en"
                                        ? "Female"
                                        : "Perempuan";
                                    ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $tanggal; ?></label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                max="<?php echo date('Y-m-d'); ?>"
                                value="<?php echo htmlspecialchars($tanggalLahir); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label><?php echo $cabang; ?></label>

                            <select name="cabang_olahraga" required>
                                <option value="">
                                    <?php echo $pilihCabang; ?>
                                </option>

                                <?php foreach ($cabangPilihan as $pilihan) { ?>
                                    <option
                                        value="<?php echo htmlspecialchars($pilihan); ?>"
                                        <?php if ($cabangOlahraga == $pilihan) echo "selected"; ?>
                                    >
                                        <?php
                                        if ($bahasa == "en") {
                                            if ($pilihan == "Lainnya") {
                                                echo "Other";
                                            } else {
                                                echo htmlspecialchars($pilihan);
                                            }
                                        } else {
                                            echo htmlspecialchars($pilihan);
                                        }
                                        ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $telepon; ?></label>

                            <input
                                type="text"
                                name="nomor_telepon"
                                maxlength="20"
                                value="<?php echo htmlspecialchars($nomorTelepon); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label><?php echo $kategori; ?></label>

                            <select name="kategori" required>
                                <option value="">
                                    <?php echo $pilihKategori; ?>
                                </option>

                                <option
                                    value="Remaja"
                                    <?php if ($kategoriAtlet == "Remaja") echo "selected"; ?>
                                >
                                    <?php echo $remaja; ?>
                                </option>

                                <option
                                    value="Dewasa"
                                    <?php if ($kategoriAtlet == "Dewasa") echo "selected"; ?>
                                >
                                    <?php echo $dewasa; ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $tahun; ?></label>

                            <input
                                type="number"
                                name="tahun_bergabung"
                                min="1900"
                                max="<?php echo date('Y'); ?>"
                                value="<?php echo htmlspecialchars((string) $tahunBergabung); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label><?php echo $status; ?></label>

                            <select name="status" required>
                                <option value="">
                                    <?php echo $pilihStatus; ?>
                                </option>

                                <option
                                    value="Aktif"
                                    <?php if ($statusAtlet == "Aktif") echo "selected"; ?>
                                >
                                    <?php echo $aktif; ?>
                                </option>

                                <option
                                    value="Tidak Aktif"
                                    <?php if ($statusAtlet == "Tidak Aktif") echo "selected"; ?>
                                >
                                    <?php echo $tidakAktif; ?>
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="form-actions">

                        <a class="button-secondary" href="index.php">
                            <?php echo $batal; ?>
                        </a>

                        <button type="submit" class="button">
                            <?php echo $simpan; ?>
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>
</html>
