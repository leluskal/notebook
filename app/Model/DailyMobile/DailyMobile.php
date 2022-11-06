<?php
declare(strict_types=1);

namespace App\Model\DailyMobile;

class DailyMobile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $screenUsageTime;

    /**
     * @var int
     */
    private $numberOfScreenUnlocks;

    /**
     * @var string
     */
    private $dayType;

    /**
     * @var int|null
     */
    private $nonInteractiveModeTime;

    /**
     * @var int|null
     */
    private $readingTime;

    /**
     * @var int|null
     */
    private $playingTime;

    /**
     * @var int|null
     */
    private $instaTime;

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
        int $screenUsageTime,
        int $numberOfScreenUnlocks,
        string $dayType,
        int $dayNumber,
        int $month,
        int $year,
        $created
    )
    {
        $this->screenUsageTime = $screenUsageTime;
        $this->numberOfScreenUnlocks = $numberOfScreenUnlocks;
        $this->dayType = $dayType;
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

    public function getScreenUsageTime(): int
    {
        return $this->screenUsageTime;
    }

    public function setScreenUsageTime(int $screenUsageTime): void
    {
        $this->screenUsageTime = $screenUsageTime;
    }

    public function getNumberOfScreenUnlocks(): int
    {
        return $this->numberOfScreenUnlocks;
    }

    public function setNumberOfScreenUnlocks(int $numberOfScreenUnlocks): void
    {
        $this->numberOfScreenUnlocks = $numberOfScreenUnlocks;
    }

    public function getDayType(): string
    {
        return $this->dayType;
    }

    public function setDayType(string $dayType): void
    {
        $this->dayType = $dayType;
    }

    public function getNonInteractiveModeTime(): ?int
    {
        return $this->nonInteractiveModeTime;
    }

    public function setNonInteractiveModeTime(?int $nonInteractiveModeTime): void
    {
        $this->nonInteractiveModeTime = $nonInteractiveModeTime;
    }

    public function getReadingTime(): ?int
    {
        return $this->readingTime;
    }

    public function setReadingTime(?int $readingTime): void
    {
        $this->readingTime = $readingTime;
    }

    public function getPlayingTime(): ?int
    {
        return $this->playingTime;
    }

    public function setPlayingTime(?int $playingTime): void
    {
        $this->playingTime = $playingTime;
    }

    public function getInstaTime(): ?int
    {
        return $this->instaTime;
    }

    public function setInstaTime(?int $instaTime): void
    {
        $this->instaTime = $instaTime;
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