<?php
declare(strict_types=1);

namespace FlipPlay\Models;

abstract class Media
{
    private string $id;
    private string $title;
    private string $creator;
    private int $year;
    private string $description;

    public function __construct(
        string $id,
        string $title,
        string $creator,
        int $year,
        string $description
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->creator = $creator;
        $this->year = $year;
        $this->description = $description;
    }

    abstract public function getType(): string;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDetails(): string
    {
        return "ID: {$this->id}\n"
            . "Judul: {$this->title}\n"
            . "Jenis: {$this->getType()}\n"
            . "Kreator: {$this->creator}\n"
            . "Tahun: {$this->year}\n"
            . "Deskripsi: {$this->description}";
    }
}
