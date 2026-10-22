# AthleteHub — Sistem Informasi Pendataan Atlet UKM

AthleteHub merupakan aplikasi berbasis web untuk mengelola data atlet UKM, mulai dari penambahan, pengubahan, penghapusan, hingga penyajian laporan data atlet.

Aplikasi dikembangkan menggunakan PHP, MySQL, HTML, dan CSS. **Laragon** digunakan sebagai lingkungan pengembangan lokal, sedangkan **HeidiSQL** digunakan untuk mengelola database.

## Akun Login Demo

- **Username:** `admin`
- **Password:** `admin123`

### Cara Menjalankan Program

1. Jalankan Laragon dan aktifkan Apache serta MySQL.
2. Simpan folder proyek di dalam `C:\laragon\www\`.
3. Buka HeidiSQL dan hubungkan ke server MySQL.
4. Impor file `pendataan_atlet.sql` untuk membuat database beserta tabel dan datanya secara otomatis.
5. Buka browser dan akses `http://localhost/NAMA_FOLDER/login.php`, sesuaikan `NAMA_FOLDER` dengan nama folder proyek.
6. Masukkan Username dan Password di atas

**Catatan:** Pastikan nama folder proyek sesuai dengan alamat yang digunakan. Jika nama folder berbeda, sesuaikan alamat localhost.

