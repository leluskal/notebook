<?php
declare(strict_types=1);

namespace App\Model\Diary;

class Diary
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $heading;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var string
     */
    private $month;

    /**
     * @var int
     */
    private $year;

    private $created;

    public function __construct(string $heading, string $notes, string $month, int $year, $created)
    {
        $this->heading = $heading;
        $this->notes = $notes;
        $this->month = $month;
        $this->year = $year;
        $this->created = $created;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function setHeading(string $heading): void
    {
        $this->heading = $heading;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function setMonth(string $month): void
    {
        $this->month = $month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): void
    {
        $this->created = $created;
    }
}