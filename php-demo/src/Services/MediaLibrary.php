<?php
declare(strict_types=1);

namespace FlipPlay\Services;

use FlipPlay\Models\Media;

class MediaLibrary
{
    /** @var Media[] */
    private array $mediaList = [];

    public function addMedia(Media $media): void
    {
        foreach ($this->mediaList as $item) {
            if ($item->getId() === $media->getId()) {
                echo "Media dengan ID {$media->getId()} sudah terdaftar.\n";
                return;
            }
        }

        $this->mediaList[] = $media;
        echo "{$media->getType()} \"{$media->getTitle()}\" berhasil ditambahkan ke library.\n";
    }

    /** @return Media[] */
    public function getMediaList(): array
    {
        return $this->mediaList;
    }

    public function showMediaList(): void
    {
        echo "\nDaftar Media FlipPlay\n";

        if (count($this->mediaList) === 0) {
            echo "Belum ada media di library.\n";
            return;
        }

        foreach ($this->mediaList as $index => $media) {
            echo ($index + 1) . ". {$media->getTitle()}"
                . " | {$media->getType()}"
                . " | {$media->getYear()}\n";
        }
    }

    public function searchByTitle(string $keyword): ?Media
    {
        foreach ($this->mediaList as $media) {
            if (stripos($media->getTitle(), $keyword) !== false) {
                return $media;
            }
        }

        return null;
    }

    public function showDetails(string $keyword): void
    {
        $media = $this->searchByTitle($keyword);

        echo "\nDetail Media\n";

        if ($media === null) {
            echo "Media dengan judul \"$keyword\" tidak ditemukan.\n";
            return;
        }

        echo $media->getDetails() . "\n";
    }
}
