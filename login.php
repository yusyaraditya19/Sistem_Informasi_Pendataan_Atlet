<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION["bahasa"])) {
    $_SESSION["bahasa"] = "id";
}

if (isset($_GET["pilih"])) {
    if ($_GET["pilih"] == "id" || $_GET["pilih"] == "en") {
        $_SESSION["bahasa"] = $_GET["pilih"];
    }

    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

$bahasa = $_SESSION["bahasa"];
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username != "" && $password != "") {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "username" => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["login"] = true;
            $_SESSION["username"] = $user["username"];

            header("Location: index.php");
            exit;
        }
    }

    $pesan = $bahasa == "en"
        ? "Incorrect username or password."
        : "Nama pengguna atau kata sandi salah.";
}
?>

<!DOCTYPE html>
<html lang="<?php echo $bahasa; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php
        echo $bahasa == "en"
            ? "Login - AthleteHub"
            : "Masuk - AthleteHub";
        ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

    <div class="login-container">
        <div class="login-card">

            <div class="login-language">
                <a
                    href="login.php?pilih=id"
                    class="<?php echo $bahasa == "id" ? "active" : ""; ?>"
                >ID</a>

                <span>|</span>

                <a
                    href="login.php?pilih=en"
                    class="<?php echo $bahasa == "en" ? "active" : ""; ?>"
                >ENG</a>
            </div>

            <div class="login-header">
                <h1>AthleteHub</h1>

                <p>
                    <?php
                    echo $bahasa == "en"
                        ? "Student Sports Club Athlete Information System"
                        : "Sistem Informasi Pendataan Atlet UKM";
                    ?>
                </p>
            </div>

            <div class="login-content">

                <?php if ($pesan != "") { ?>
                    <p class="error">
                        <?php echo htmlspecialchars($pesan); ?>
                    </p>
                <?php } ?>

                <form method="POST" action="login.php">

                    <div class="form-group">
                        <label for="username">
                            <?php
                            echo $bahasa == "en"
                                ? "Username"
                                : "Nama Pengguna";
                            ?>
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            maxlength="50"
                            placeholder="<?php echo $bahasa == "en" ? "Enter your username" : "Masukkan nama pengguna"; ?>"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <?php
                            echo $bahasa == "en"
                                ? "Password"
                                : "Kata Sandi";
                            ?>
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="<?php echo $bahasa == "en" ? "Enter your password" : "Masukkan kata sandi"; ?>"
                            required
                        >
                    </div>

                    <button type="submit" class="button login-button">
                        <?php
                        echo $bahasa == "en"
                            ? "Sign In"
                            : "Masuk";
                        ?>
                    </button>

                </form>
            </div>

            <div class="login-footer">
                <?php
                echo $bahasa == "en"
                    ? "AthleteHub — Athletes Information System"
                    : "AthleteHub — Sistem Informasi Atlet";
                ?>
            </div>

        </div>
    </div>

</body>
</html>
