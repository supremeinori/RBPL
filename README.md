# RBPL - Sistem Manajemen Order & Desain

**RBPL** adalah aplikasi berbasis web yang dirancang untuk mengelola proses pemesanan (order), desain, dan pembayaran dalam alur kerja percetakan atau agensi desain. Aplikasi ini mempermudah kolaborasi antara Admin, Desainer, dan Akuntan dalam satu platform yang terintegrasi.

---

## 🚀 Fitur Utama

- **Manajemen Pelanggan**: Penyimpanan data pelanggan yang terintegrasi.
- **Manajemen Order**: Pembuatan dan pelacakan status pesanan secara real-time.
- **Iterasi Desain**: Alur kerja peninjauan desain antara Admin dan Desainer.
- **Validasi Pembayaran**: Sistem konfirmasi pembayaran oleh Akuntan.
- **Laporan Keuangan**: Rekapitulasi pendapatan dalam format PDF dan CSV.
- **Backup Data**: Fitur pencadangan basis data (untuk Super Admin).
- **Role-Based Access Control (RBAC)**: Pembatasan akses sesuai dengan peran masing-masing pengguna.

---

## 👥 Peran Pengguna (Roles)

| Role | Deskripsi Singkat |
| :--- | :--- |
| **Super Admin** | Memiliki akses penuh, mengelola akun user lain, dan melakukan backup sistem. |
| **Admin** | Membuat order baru, mengelola pelanggan, dan menyetujui/merevisi desain dari Desainer. |
| **Desainer** | Melihat daftar order yang ditugaskan dan mengunggah draft desain untuk ditinjau. |
| **Akuntan** | Memvalidasi bukti pembayaran dari pelanggan dan mengunduh laporan keuangan. |

---

## 🔄 Alur Kerja Inti

1. **Order Baru**: Admin membuat pesanan untuk pelanggan.
2. **Penugasan**: Admin menugaskan Desainer untuk mengerjakan desain pesanan tersebut.
3. **Drafting**: Desainer mengunggah draft desain melalui dashboard mereka.
4. **Approval**: Admin meninjau desain. Jika sesuai, desain disetujui; jika tidak, Admin meminta revisi.
5. **Pembayaran**: Setelah desain oke, Admin mencatat kesepakatan harga. Pelanggan melakukan pembayaran.
6. **Validasi**: Akuntan memverifikasi pembayaran. Jika valid, status pesanan berubah menjadi lunas/selesai.

---

## 🛠️ Persyaratan Sistem

- **PHP**: ^8.1
- **Composer**: ^2.0
- **Database**: MariaDB / MySQL
- **Node.js**: ^18.0 (untuk kompilasi asset Vite)
- **Local Server**: Laragon (disarankan), XAMPP, atau Laravel Herd.

---

## ⚙️ Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan projek di komputer lokal Anda:

1. **Clone Repositori**
   ```bash
   git clone https://github.com/supremeinori/RBPL.git
   cd RBPL
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrasi & Seeding**
   Buat database baru di MySQL, lalu jalankan perintah berikut:
   ```bash
   php artisan migrate --seed
   ```

6. **Build Asset**
   ```bash
   npm run dev
   # atau untuk produksi
   npm run build
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses di: `http://localhost:8000`

---

## 🌐 Panduan Deployment (VPS)

Untuk men-deploy aplikasi ini ke VPS (Ubuntu/Nginx):

1. **Setup Server**: Pastikan PHP 8.1+, Nginx, dan MySQL sudah terinstal.
2. **Setup Folder**: Clone repositori ke `/var/www/rbpl`.
3. **Permissions**: Pastikan folder `storage` dan `bootstrap/cache` bisa ditulis oleh user `www-data`.
   ```bash
   sudo chown -R www-data:www-data /var/www/rbpl/storage /var/www/rbpl/bootstrap/cache
   ```
4. **Nginx Config**: Buat konfigurasi block untuk mengarahkan ke folder `public`.
5. **SSL**: Gunakan `Certbot` untuk mendapatkan SSL gratis dari Let's Encrypt.
6. **Optimasi**: Jalankan perintah optimasi Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 📄 Lisensi

Projek ini mengikuti lisensi [MIT](https://opensource.org/licenses/MIT).
