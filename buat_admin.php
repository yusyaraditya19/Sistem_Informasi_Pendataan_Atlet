<?php
require_once "koneksi.php";

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password)
        VALUES (:username, :password)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "username" => $username,
    "password" => $password
]);

echo "Akun admin berhasil dibuat.";
?>