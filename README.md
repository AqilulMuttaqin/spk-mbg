# 📂 SPK MBG

Aplikasi **SPK MBG** berbasis web yang dibuat menggunakan **Laravel 12**.  
Proyek digunakan untuk memberikan rekomendasi sekolah prioritas penerima program Makan Bergizi Gratis (MBG) dengan menggunakan metode ELECTRE I, II, dan III.

---

## 🚀 Fitur
- ✉️ **Dashboard**
  - Informasi utama terkait aplikasi
- 📑 **Manajemen Kriteria**
  - Tambah, edit, hapus, dan cari kriteria
- 📑 **Manajemen Wilayah**
  - Tambah, edit, hapus, cari wilayah, dan input nilai kriteria
- 📑 **Manajemen Sekolah**
  - Tambah, edit, hapus, cari Sekolah, dan input nilai kriteria
- 🔎 **Rekomendasi Prioritas**
  - Rekomendasi menggunakan ELECTRE I
  - Rekomendasi menggunakan ELECTRE II
  - Rekomendasi menggunakan ELECTRE III

---

## 🛠️ Teknologi yang Digunakan
- [Laravel 12](https://laravel.com/)
- [Blade Template](https://laravel.com/docs/blade)
- [Bootstrap](https://getbootstrap.com/) + [Admin Kit](https://adminkit.io/)
- MySQL

---

## ⚙️ Instalasi

1. Clone repository ini:
   ```bash
   git clone https://github.com/AqilulMuttaqin/spk-mbg.git
   cd spk-mbg

2. Install dependencies Laravel:
   ```bash
   composer install
   npm install

3. Copy file .env.example menjadi .env dan sesuaikan konfigurasi database:
   ```bash
   cp .env.example .env

4. Generate key Laravel:
   ```bash
   php artisan key:generate

5. Migrasi dan seeder database:
   ```bash
   php artisan migrate
   php artisan db:seed

6. Jalankan Aplikasi
   ```bash
   php artisan serve

## 👨‍💻 Author
- Muhammad Aqilul Muttaqin
- NIM: 2141720182
- Prodi: D4 Teknik Informatika
