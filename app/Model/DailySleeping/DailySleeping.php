<?php
declare(strict_types=1);

namespace App\Model\DailySleeping;

class DailySleeping
{
    /**
     * @var int
     */
    private $id;

    private $timeGoToBed;

    private $timeGetUp;

    /**
     * @var string
     */
    private $dayType;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int
     */
    private $illness;

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
        $timeGoToBed,
        $timeGetUp,
        string $dayType,
        int $illness,
        int $dayNumber,
        int $month,
        int $year,
        $created
    )
    {
        $this->timeGoToBed = $timeGoToBed;
        $this->timeGetUp = $timeGetUp;
        $this->dayType = $dayType;
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

    public function getTimeGoToBed()
    {
        return $this->timeGoToBed;
    }

    public function setTimeGoToBed($timeGoToBed): void
    {
        $this->timeGoToBed = $timeGoToBed;
    }

    public function getTimeGetUp()
    {
        return $this->timeGetUp;
    }

    public function setTimeGetUp($timeGetUp): void
    {
        $this->timeGetUp = $timeGetUp;
    }

    public function getDayType(): string
    {
        return $this->dayType;
    }

    public function setDayType(string $dayType): void
    {
        $this->dayType = $dayType;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getIllness(): int
    {
        return $this->illness;
    }

    public function setIllness(int $illness): void
    {
        $this->illness = $illness;
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