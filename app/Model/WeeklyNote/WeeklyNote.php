<?php
declare(strict_types=1);

namespace App\Model\WeeklyNote;

class WeeklyNote
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $plan;

    /**
     * @var string|null
     */
    private $reality;

    /**
     * @var int|null
     */
    private $rating;

    /**
     * @var int
     */
    private $weekNumber;

    /**
     * @var int
     */
    private $year;

    public function __construct(string $plan, int $weekNumber, int $year)
    {
        $this->plan = $plan;
        $this->weekNumber = $weekNumber;
        $this->year = $year;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function setPlan(string $plan): void
    {
        $this->plan = $plan;
    }

    public function getReality(): ?string
    {
        return $this->reality;
    }

    public function setReality(?string $reality): void
    {
        $this->reality = $reality;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    public function setWeekNumber(int $weekNumber): void
    {
        $this->weekNumber = $weekNumber;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}