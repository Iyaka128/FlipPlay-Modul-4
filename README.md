# FlipPlay — The Vibe Grid (Module 2 Demo)

Implementasi Demo Modul 2 Pemrograman Web menggunakan JavaScript dasar, fitur ES6+, DOM manipulation, event handling, array methods, async/await, dan Fetch API.

## Menjalankan proyek
1. Ekstrak ZIP.
2. Buka folder proyek di VS Code.
3. Jalankan `src/index.html` menggunakan Live Server atau server lokal.
4. Pastikan koneksi internet aktif agar Jikan API dapat diakses.

## Fitur Demo
- Unified Search: pencarian judul anime secara real-time.
- Aura-Based Discovery: filter `High Energy`, `Melancholy`, dan `Binge Mode`.
- Fetch API GET ke Jikan API.
- Loading state dan pesan error.
- Kartu anime dengan poster, skor, jumlah episode, genre, dan tautan detail.
- Tombol muat lebih banyak.
- Navbar toggle untuk layar kecil.

## Catatan
Data diambil dari `https://api.jikan.moe/v4/top/anime?limit=24`. Kategori Aura merupakan filter sederhana berdasarkan genre dan jumlah episode dari data yang sudah diambil, bukan klasifikasi suasana hati resmi dari API.


## Demo Modul 3 — PHP OOP

Prototype backend PHP untuk Demo Modul 3 tersedia di folder `php-demo/`. Jalankan dari terminal dengan `php index.php`.


## Demo Modul 4 — Laravel REST API

Paket backend Laravel 12 dan panduan setup ada di folder `laravel-backend/`. Lihat `README-DEMO-MODUL-4.md` untuk instruksi instalasi dan pengujian Postman.
