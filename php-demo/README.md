# FlipPlay — PHP OOP Backend Demo (Module 3)

Folder `php-demo` berisi prototype backend FlipPlay menggunakan PHP murni dan OOP. Program dijalankan melalui terminal, bukan sebagai aplikasi web.

## Cara menjalankan

1. Pastikan PHP 8.x sudah terpasang.
2. Buka terminal pada folder `php-demo`.
3. Jalankan:

```bash
php index.php
```

## Alur simulasi

1. Membuat beberapa media (Anime, Manga, Drama).
2. Menambahkan media ke library.
3. Menampilkan daftar media.
4. Mencari media berdasarkan judul.
5. Menampilkan detail media.
6. Menambahkan media ke koleksi pengguna.
7. Menampilkan koleksi pengguna.

## Penerapan ketentuan Demo Modul 3

- Minimal tiga class: `Media`, `Anime`, `Manga`, `Drama`, `User`, dan `MediaLibrary`.
- Constructor `__construct()` digunakan untuk menginisialisasi objek.
- Properties dan methods tersedia pada setiap class.
- Access modifiers: properties menggunakan `private`; method yang dibutuhkan class lain menggunakan `public`.
- Inheritance: `Anime`, `Manga`, dan `Drama` mewarisi abstract class `Media`.
- Namespace: `FlipPlay\\Models` dan `FlipPlay\\Services`.
- Type hinting dan return type diterapkan pada parameter dan method.
- `index.php` menjadi entry point simulasi.

## Struktur folder

```text
php-demo/
├── index.php
├── README.md
└── src/
    ├── Models/
    │   ├── Media.php
    │   ├── Anime.php
    │   ├── Manga.php
    │   ├── Drama.php
    │   └── User.php
    └── Services/
        └── MediaLibrary.php
```

## Catatan

Data media pada simulasi ini merupakan data contoh yang ditulis langsung di `index.php`. Prototype ini belum terhubung ke database atau API Kitsu dari website Modul 2. Pemisahan ini disengaja agar demo berfokus pada konsep backend PHP OOP sesuai instruksi Modul 3.
