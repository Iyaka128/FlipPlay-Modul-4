# FlipPlay — Demo Modul 4 (Laravel 12 REST API)

Folder `laravel-backend/` adalah paket file backend untuk digabungkan ke proyek Laravel 12 baru. ZIP sumber FlipPlay Modul 3 tidak berisi instalasi Laravel, sehingga folder ini sengaja disediakan sebagai **overlay**, bukan diklaim sebagai proyek Laravel yang sudah terinstal.

## 1. Buat proyek Laravel 12

Di terminal, dari folder `flipplay_work` (folder yang berisi `src/`, `images/`, `php-demo/`), jalankan:

```bash
composer create-project laravel/laravel:^12.0 flipplay-api
cd flipplay-api
php artisan install:api
```

`php artisan install:api` membuat `routes/api.php` jika belum ada.

## 2. Salin file overlay

Salin seluruh isi folder `laravel-backend/` ke folder `flipplay-api/`, dengan mempertahankan struktur folder. Jika diminta, gabungkan folder `app`, `database`, dan `routes`.

File `app/Models/User.php` pada paket ini menggantikan User model bawaan Laravel dan tetap mempertahankan autentikasi standar Laravel.

## 3. Siapkan database

Buat database MySQL bernama `flipplay` (atau nama lain), lalu sesuaikan `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flipplay
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed --class=FlipPlaySeeder
php artisan route:list --path=api
php artisan serve
```

Seeder membuat user demo `demo@flipplay.test` dan empat media contoh. Gunakan ID aktual yang dikembalikan API; jangan mengasumsikan ID selalu 1 jika database sudah berisi data.

## 4. Endpoint API

Base URL: `http://127.0.0.1:8000/api`

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/media` | Daftar media, pagination |
| GET | `/media?search=blue` | Cari judul |
| GET | `/media?type=Anime` | Filter jenis |
| GET | `/media/{id}` | Detail media + users yang memasukkan ke koleksi |
| POST | `/media` | Tambah media |
| PATCH | `/media/{id}` | Ubah media |
| DELETE | `/media/{id}` | Hapus media |
| GET | `/users/{user}/collection` | Lihat koleksi user |
| POST | `/users/{user}/collection/{media}` | Attach media ke koleksi |
| DELETE | `/users/{user}/collection/{media}` | Detach media dari koleksi |

## 5. Contoh request Postman

Semua request POST/PATCH menggunakan header `Accept: application/json` dan `Content-Type: application/json`.

### Create media — POST `/api/media`

```json
{
  "title": "Your Name",
  "type": "Anime",
  "genre": "Romance, Fantasy",
  "description": "Dua remaja terhubung melalui fenomena misterius.",
  "cover_url": "https://example.com/your-name.jpg",
  "release_year": 2016
}
```

Expected: `201 Created`.

### Update media — PATCH `/api/media/1`

```json
{
  "genre": "Romance, Drama",
  "release_year": 2016
}
```

Expected: `200 OK`.

### Attach — POST `/api/users/1/collection/1`

Expected: `201 Created`. Jika media sudah ada dalam koleksi user yang sama: `409 Conflict`.

### Detach — DELETE `/api/users/1/collection/1`

Expected: `200 OK`. Jika media tidak ada di koleksi: `404 Not Found`.

### Failure validation — POST `/api/media`

```json
{
  "title": "",
  "type": "Film"
}
```

Expected: `422 Unprocessable Entity`, dengan detail pada properti `errors`.

### Duplicate title — POST `/api/media`

Kirim judul yang sudah ada, misalnya `Blue Lock`.

Expected: `422 Unprocessable Entity`.

## 6. Postman Collection

Impor file `postman/FlipPlay-Modul-4.postman_collection.json` ke Postman. Collection menggunakan variable `base_url`, `user_id`, dan `media_id`. Setelah seed, user demo bisa dicari melalui `GET /api/users/1/collection` atau tabel users; sesuaikan `user_id` dengan ID aktual.

## 7. Kriteria rubrik yang dicakup

- CRUD Media lengkap: index, show, store, update, destroy.
- Relasi many-to-many User–Media menggunakan pivot `media_user`.
- Eager loading `users` di endpoint media dan `media` pada koleksi user.
- Form Request terpisah untuk create dan update; validasi Laravel menghasilkan 422.
- API Resources menjaga format JSON dan menggunakan `whenLoaded`.
- Custom actions attach/detach koleksi.
- Postman Collection untuk happy path dan failure path.

## Catatan integrasi frontend

Website Modul 2 tetap berada di `src/` dan tidak diubah. Demo Modul 4 berfokus pada REST API sesuai instruksi modul; integrasi JavaScript frontend ke endpoint Laravel dapat menjadi pengembangan lanjutan.
