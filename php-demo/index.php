<?php
declare(strict_types=1);

require_once __DIR__ . "/src/Models/Media.php";
require_once __DIR__ . "/src/Models/Anime.php";
require_once __DIR__ . "/src/Models/Manga.php";
require_once __DIR__ . "/src/Models/Drama.php";
require_once __DIR__ . "/src/Models/User.php";
require_once __DIR__ . "/src/Services/MediaLibrary.php";

use FlipPlay\Models\Anime;
use FlipPlay\Models\Drama;
use FlipPlay\Models\Manga;
use FlipPlay\Models\User;
use FlipPlay\Services\MediaLibrary;



$library = new MediaLibrary();
$user = new User("Iyaka");



echo "====================================\n";
echo "       FLIPPLAY BACKEND ENGINE\n";
echo "====================================\n";
echo "\n[1] Menambahkan media ke library\n";

$anime = new Anime(
    "A001",
    "Frieren: Beyond Journey's End",
    "Kanehito Yamada",
    2023,
    "Petualangan seorang penyihir elf setelah perjalanan mengalahkan Raja Iblis.",
    28
);

$manga = new Manga(
    "M001",
    "Blue Lock",
    "Muneyuki Kaneshiro",
    2018,
    "Kompetisi sepak bola untuk menemukan striker terbaik Jepang.",
    35
);

$drama = new Drama(
    "D001",
    "Moving",
    "Kang Full",
    2023,
    "Drama tentang remaja dengan kekuatan super dan rahasia keluarga mereka.",
    20
);

$library->addMedia($anime);
$library->addMedia($manga);
$library->addMedia($drama);



echo "\n[2] Menampilkan seluruh media\n";
$library->showMediaList();



echo "\n[3] Mencari media berdasarkan judul\n";
$keyword = "Blue Lock";
$foundMedia = $library->searchByTitle($keyword);

if ($foundMedia !== null) {
    echo "Media ditemukan: {$foundMedia->getTitle()}\n";
} else {
    echo "Media \"$keyword\" tidak ditemukan.\n";
}



echo "\n[4] Menampilkan detail media\n";
$library->showDetails("Frieren");



echo "\n[5] Mengelola koleksi pengguna\n";
$user->addToCollection($anime);
$user->addToCollection($manga);
$user->showCollection();

echo "\n====================================\n";
echo "       SIMULASI SELESAI\n";
echo "====================================\n";
