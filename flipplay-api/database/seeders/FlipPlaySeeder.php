<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FlipPlaySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@flipplay.test'],
            [
                'name' => 'FlipPlay Demo User',
                'password' => Hash::make('password'),
            ]
        );

        $samples = [
            [
                'title' => "Frieren: Beyond Journey's End",
                'type' => 'Anime',
                'genre' => 'Adventure, Fantasy',
                'description' => 'Petualangan seorang penyihir elf setelah perjalanan mengalahkan Raja Iblis.',
                'release_year' => 2023,
            ],
            [
                'title' => 'Blue Lock',
                'type' => 'Manga',
                'genre' => 'Sports',
                'description' => 'Kompetisi untuk menemukan striker terbaik Jepang.',
                'release_year' => 2018,
            ],
            [
                'title' => 'Moving',
                'type' => 'Drama',
                'genre' => 'Action, Supernatural',
                'description' => 'Drama tentang remaja dengan kekuatan super dan rahasia keluarga.',
                'release_year' => 2023,
            ],
            [
                'title' => 'Classroom of the Elite',
                'type' => 'Light Novel',
                'genre' => 'Psychological',
                'description' => 'Kisah siswa di sekolah dengan sistem persaingan yang ketat.',
                'release_year' => 2015,
            ],
        ];

        foreach ($samples as $sample) {
            Media::firstOrCreate(
                ['title' => $sample['title']],
                $sample
            );
        }

        $frieren = Media::where('title', "Frieren: Beyond Journey's End")->first();
        $blueLock = Media::where('title', 'Blue Lock')->first();

        if ($frieren) {
            $user->media()->syncWithoutDetaching([$frieren->id]);
        }

        if ($blueLock) {
            $user->media()->syncWithoutDetaching([$blueLock->id]);
        }
    }
}
