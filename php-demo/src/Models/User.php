<?php
declare(strict_types=1);

namespace FlipPlay\Models;

class User
{
    private string $name;

    /** @var Media[] */
    private array $collection = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addToCollection(Media $media): void
    {
        foreach ($this->collection as $item) {
            if ($item->getId() === $media->getId()) {
                echo "Media sudah ada di koleksi {$this->name}.\n";
                return;
            }
        }

        $this->collection[] = $media;
        echo "\"{$media->getTitle()}\" berhasil ditambahkan ke koleksi {$this->name}.\n";
    }

    public function showCollection(): void
    {
        echo "\nKoleksi Media {$this->name}\n";

        if (count($this->collection) === 0) {
            echo "Koleksi masih kosong.\n";
            return;
        }

        foreach ($this->collection as $index => $media) {
            echo ($index + 1) . ". {$media->getTitle()} ({$media->getType()})\n";
        }
    }
}
