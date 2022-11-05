<?php
declare(strict_types=1);

namespace App\Model\DailyEating;

class DailyEating
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $calorieNumber;

    /**
     * @var int
     */
    private $calorieEstimate;

    /**
     * @var int
     */
    private $outsideFood;

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
        int $calorieNumber,
        int $calorieEstimate,
        int $outsideFood,
        string $dayType,
        int $dayNumber,
        int $month,
        int $year,
        $created
    )
    {
        $this->calorieNumber = $calorieNumber;
        $this->calorieEstimate = $calorieEstimate;
        $this->outsideFood = $outsideFood;
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

    public function getCalorieNumber(): int
    {
        return $this->calorieNumber;
    }

    public function setCalorieNumber(int $calorieNumber): void
    {
        $this->calorieNumber = $calorieNumber;
    }

    public function getCalorieEstimate(): int
    {
        return $this->calorieEstimate;
    }

    public function setCalorieEstimate(int $calorieEstimate): void
    {
        $this->calorieEstimate = $calorieEstimate;
    }

    public function getOutsideFood(): int
    {
        return $this->outsideFood;
    }

    public function setOutsideFood(int $outsideFood): void
    {
        $this->outsideFood = $outsideFood;
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