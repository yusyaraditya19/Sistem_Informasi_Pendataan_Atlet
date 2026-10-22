<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$bahasa = isset($_SESSION["bahasa"])
    ? $_SESSION["bahasa"]
    : "id";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

$query = $pdo->prepare("SELECT * FROM atlet WHERE id_atlet = ?");
$query->execute([$id]);
$atlet = $query->fetch(PDO::FETCH_ASSOC);

if (!$atlet) {
    header("Location: index.php");
    exit;
}

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["nama_atlet"]);
    $jenisKelamin = $_POST["jenis_kelamin"];
    $tanggalLahir = $_POST["tanggal_lahir"];
    $cabang = $_POST["cabang_olahraga"];
    $telepon = trim($_POST["nomor_telepon"]);
    $kategori = $_POST["kategori"];
    $tahun = $_POST["tahun_bergabung"];
    $status = $_POST["status"];

    if (
        $nama == "" || $jenisKelamin == "" ||
        $tanggalLahir == "" || $cabang == "" ||
        $telepon == "" || $kategori == "" ||
        $tahun == "" || $status == ""
    ) {
        $pesan = $bahasa == "en"
            ? "All fields are required."
            : "Semua kolom wajib diisi.";
    } elseif (!is_numeric($tahun) || $tahun < 1900 || $tahun > date("Y")) {
        $pesan = $bahasa == "en"
            ? "Invalid joining year."
            : "Tahun bergabung tidak valid.";
    } elseif (!preg_match("/^[0-9+ -]+$/", $telepon)) {
        $pesan = $bahasa == "en"
            ? "Invalid phone number."
            : "Nomor telepon tidak valid.";
    } else {
        $sql = "UPDATE atlet SET
                nama_atlet = ?,
                jenis_kelamin = ?,
                tanggal_lahir = ?,
                cabang_olahraga = ?,
                nomor_telepon = ?,
                kategori = ?,
                tahun_bergabung = ?,
                status = ?
                WHERE id_atlet = ?";

        $query = $pdo->prepare($sql);
        $query->execute([
            $nama, $jenisKelamin, $tanggalLahir,
            $cabang, $telepon, $kategori, $tahun, $status, $id
        ]);

        header("Location: index.php");
        exit;
    }

    $atlet["nama_atlet"] = $nama;
    $atlet["jenis_kelamin"] = $jenisKelamin;
    $atlet["tanggal_lahir"] = $tanggalLahir;
    $atlet["cabang_olahraga"] = $cabang;
    $atlet["nomor_telepon"] = $telepon;
    $atlet["kategori"] = $kategori;
    $atlet["tahun_bergabung"] = $tahun;
    $atlet["status"] = $status;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $bahasa; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $bahasa == "en" ? "Edit Athlete - AthleteHub" : "Edit Atlet - AthleteHub"; ?>
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
            Dashboard
        </a>

        <a class="nav-link active" href="tambah.php">
            <?php
            echo $bahasa == "en"
                ? "Edit Athlete Data"
                : "Edit Data Atlet";
            ?>
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
            <a class="nav-link logout-link" href="logout.php">
                <?php echo $bahasa == "en" ? "Logout" : "Keluar"; ?>
            </a>
        </div>
    </aside>

    <main class="main">

        <header class="topbar">
            <div class="topbar-title">
                <h1>
                    <?php
                    echo $bahasa == "en"
                        ? "Edit Athlete"
                        : "Edit Atlet";
                    ?>
                </h1>

                <p>
                    <?php
                    echo $bahasa == "en"
                        ? "Update athlete information."
                        : "Perbarui informasi atlet.";
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

        <section class="content">

            <div class="form-card">
                <h2>
                    <?php
                    echo $bahasa == "en"
                        ? "Athlete Information"
                        : "Informasi Atlet";
                    ?>
                </h2>

                <?php if ($pesan != "") { ?>
                    <p class="error">
                        <?php echo htmlspecialchars($pesan); ?>
                    </p>
                <?php } ?>

                <form method="POST">

                    <div class="form-grid">

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Athlete Name" : "Nama Atlet"; ?>
                            </label>

                            <input
                                type="text"
                                name="nama_atlet"
                                maxlength="100"
                                value="<?php echo htmlspecialchars($atlet["nama_atlet"]); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Gender" : "Jenis Kelamin"; ?>
                            </label>

                            <select name="jenis_kelamin" required>
                                <option value="Laki-laki"
                                    <?php if ($atlet["jenis_kelamin"] == "Laki-laki") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Male" : "Laki-laki"; ?>
                                </option>

                                <option value="Perempuan"
                                    <?php if ($atlet["jenis_kelamin"] == "Perempuan") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Female" : "Perempuan"; ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Date of Birth" : "Tanggal Lahir"; ?>
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                value="<?php echo htmlspecialchars($atlet["tanggal_lahir"]); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Sport" : "Cabang Olahraga"; ?>
                            </label>

                            <select name="cabang_olahraga" required>
                                <?php
                                $cabangPilihan = [
                                    "Taekwondo", "Badminton", "Basket",
                                    "Futsal", "Voli", "Pencak Silat",
                                    "Karate", "Lainnya"
                                ];

                                foreach ($cabangPilihan as $pilihan) {
                                    $selected = ($atlet["cabang_olahraga"] == $pilihan)
                                        ? "selected" : "";

                                    echo "<option value=\"" .
                                        htmlspecialchars($pilihan) . "\" $selected>" .
                                        htmlspecialchars($pilihan) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Phone Number" : "Nomor Telepon"; ?>
                            </label>

                            <input
                                type="text"
                                name="nomor_telepon"
                                maxlength="20"
                                value="<?php echo htmlspecialchars($atlet["nomor_telepon"]); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Category" : "Kategori"; ?>
                            </label>

                            <select name="kategori" required>
                                <option value="Remaja"
                                    <?php if ($atlet["kategori"] == "Remaja") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Teenager" : "Remaja"; ?>
                                </option>

                                <option value="Dewasa"
                                    <?php if ($atlet["kategori"] == "Dewasa") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Adult" : "Dewasa"; ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Joining Year" : "Tahun Bergabung"; ?>
                            </label>

                            <input
                                type="number"
                                name="tahun_bergabung"
                                min="1900"
                                max="<?php echo date('Y'); ?>"
                                value="<?php echo htmlspecialchars((string) $atlet["tahun_bergabung"]); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>
                                <?php echo $bahasa == "en" ? "Status" : "Status"; ?>
                            </label>

                            <select name="status" required>
                                <option value="Aktif"
                                    <?php if ($atlet["status"] == "Aktif") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Active" : "Aktif"; ?>
                                </option>

                                <option value="Tidak Aktif"
                                    <?php if ($atlet["status"] == "Tidak Aktif") echo "selected"; ?>>
                                    <?php echo $bahasa == "en" ? "Inactive" : "Tidak Aktif"; ?>
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="form-actions">
                        <a class="button-secondary" href="index.php">
                            <?php echo $bahasa == "en" ? "Cancel" : "Batal"; ?>
                        </a>

                        <button type="submit" class="button">
                            <?php echo $bahasa == "en" ? "Save Changes" : "Simpan Perubahan"; ?>
                        </button>
                    </div>

                </form>
            </div>

        </section>

    </main>

</div>

</body>
</html>
