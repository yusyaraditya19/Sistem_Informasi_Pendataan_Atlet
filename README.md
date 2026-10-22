# AthleteHub — Sistem Informasi Pendataan Atlet UKM

AthleteHub merupakan aplikasi berbasis web untuk mengelola data atlet UKM, mulai dari penambahan, pengubahan, penghapusan, hingga penyajian laporan data atlet.

Aplikasi dikembangkan menggunakan PHP, MySQL, HTML, dan CSS. **Laragon** digunakan sebagai lingkungan pengembangan lokal, sedangkan **HeidiSQL** digunakan untuk mengelola database.

## Akun Login Demo

- **Username:** `admin`
- **Password:** `admin123`

## Cara Menjalankan

1. Jalankan Laragon dan aktifkan web server serta MySQL.
2. Letakkan folder proyek di `C:\laragon\www\`.
3. Buat database `pendataan_atlet` melalui HeidiSQL.
4. Impor file `pendataan_atlet.sql` ke database.
5. Buka `http://localhost/NAMA_FOLDER/login.php` di browser.

**Catatan:** Ganti `NAMA_FOLDER` sesuai nama folder proyek. Pastikan file SQL mencakup struktur tabel dan akun admin agar login dapat digunakan setelah database diimpor.

