<?php
declare(strict_types=1);

namespace App\Model\Entertainment;

use App\Model\EntertainmentType\EntertainmentType;

class Entertainment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $entertainmentTypeId;

    private $date;

    /**
     * @var string
     */
    private $details;

    /**
     * @var string
     */
    private $month;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $rating;

    /**
     * @var EntertainmentType
     */
    private $entertainmentType;

    public function __construct(int $entertainmentTypeId, $date, string $details, string $month, int $year, int $rating)
    {
        $this->entertainmentTypeId = $entertainmentTypeId;
        $this->date = $date;
        $this->details = $details;
        $this->month = $month;
        $this->year = $year;
        $this->rating = $rating;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEntertainmentTypeId(): int
    {
        return $this->entertainmentTypeId;
    }

    public function setEntertainmentTypeId(int $entertainmentTypeId): void
    {
        $this->entertainmentTypeId = $entertainmentTypeId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function setDetails(string $details): void
    {
        $this->details = $details;
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

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getEntertainmentType(): EntertainmentType
    {
        return $this->entertainmentType;
    }

    public function setEntertainmentType(EntertainmentType $entertainmentType): void
    {
        $this->entertainmentType = $entertainmentType;
    }
}