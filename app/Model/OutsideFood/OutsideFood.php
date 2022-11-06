<?php
declare(strict_types=1);

namespace App\Model\OutsideFood;

class OutsideFood
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $food;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int
     */
    private $foodDelivery;

    /**
     * @var int
     */
    private $drink;

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
        string $food,
        int    $price,
        int    $foodDelivery,
        int    $drink,
        int    $dayNumber,
        int    $month,
        int    $year,
               $created
    )
    {
        $this->food = $food;
        $this->price = $price;
        $this->foodDelivery = $foodDelivery;
        $this->drink = $drink;
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

    public function getFood(): string
    {
        return $this->food;
    }

    public function setFood(string $food): void
    {
        $this->food = $food;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getFoodDelivery(): int
    {
        return $this->foodDelivery;
    }

    public function setFoodDelivery(int $foodDelivery): void
    {
        $this->foodDelivery = $foodDelivery;
    }

    public function getDrink(): int
    {
        return $this->drink;
    }

    public function setDrink(int $drink): void
    {
        $this->drink = $drink;
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