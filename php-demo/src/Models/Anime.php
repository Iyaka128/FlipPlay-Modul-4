<?php
declare(strict_types=1);

namespace FlipPlay\Models;

class Anime extends Media
{
    private int $episodes;

    public function __construct(
        string $id,
        string $title,
        string $creator,
        int $year,
        string $description,
        int $episodes
    ) {
        parent::__construct($id, $title, $creator, $year, $description);
        $this->episodes = $episodes;
    }

    public function getType(): string
    {
        return "Anime";
    }

    public function getEpisodes(): int
    {
        return $this->episodes;
    }

    public function getDetails(): string
    {
        return parent::getDetails()
            . "\nJumlah episode: {$this->episodes}";
    }
}
