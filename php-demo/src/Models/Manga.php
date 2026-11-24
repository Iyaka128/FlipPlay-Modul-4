<?php
declare(strict_types=1);

namespace FlipPlay\Models;

class Manga extends Media
{
    private int $volumes;

    public function __construct(
        string $id,
        string $title,
        string $creator,
        int $year,
        string $description,
        int $volumes
    ) {
        parent::__construct($id, $title, $creator, $year, $description);
        $this->volumes = $volumes;
    }

    public function getType(): string
    {
        return "Manga";
    }

    public function getVolumes(): int
    {
        return $this->volumes;
    }

    public function getDetails(): string
    {
        return parent::getDetails()
            . "\nJumlah volume: {$this->volumes}";
    }
}
