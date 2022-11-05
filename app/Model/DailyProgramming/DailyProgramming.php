<?php
declare(strict_types=1);

namespace App\Model\DailyProgramming;

class DailyProgramming
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int|null
     */
    private $programmingDuration;

    /**
     * @var string|null
     */
    private $dayType;

    /**
     * @var string|null
     */
    private $dayPart;

    /**
     * @var int
     */
    private $illness;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int
     */
    private $dayNumber;

    /**
     * @var int
     */
    private $month;

    /**
     * @var int
     */
    private $year;

    private $created;

    public function __construct(
        int $illness,
        int $dayNumber,
        int $month,
        int $year,
        $created
    )
    {
        $this->illness = $illness;
        $this->dayNumber = $dayNumber;
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

    public function getProgrammingDuration(): ?int
    {
        return $this->programmingDuration;
    }

    public function setProgrammingDuration(?int $programmingDuration): void
    {
        $this->programmingDuration = $programmingDuration;
    }

    public function getDayType(): ?string
    {
        return $this->dayType;
    }

    public function setDayType(?string $dayType): void
    {
        $this->dayType = $dayType;
    }

    public function getDayPart(): ?string
    {
        return $this->dayPart;
    }

    public function setDayPart(?string $dayPart): void
    {
        $this->dayPart = $dayPart;
    }

    public function getIllness(): int
    {
        return $this->illness;
    }

    public function setIllness(int $illness): void
    {
        $this->illness = $illness;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getDayNumber(): int
    {
        return $this->dayNumber;
    }

    public function setDayNumber(int $dayNumber): void
    {
        $this->dayNumber = $dayNumber;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): void
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