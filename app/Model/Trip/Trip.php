<?php
declare(strict_types=1);

namespace App\Model\Trip;

class Trip
{
    /**
     * @var int
     */
    private $id;

    private $date;

    /**
     * @var string
     */
    private $destination;

    private $startOfTrip;

    private $endOfTrip;

    /**
     * @var int
     */
    private $rating;

    /**
     * @var int
     */
    private $year;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $details;

    /**
     * @var array
     */
    private $transportTypeIds;

    public function __construct(
        $date,
        string $destination,
        $startOfTrip,
        $endOfTrip,
        int $rating,
        int $year,
        string $month,
        string $details
    )
    {
        $this->date = $date;
        $this->destination = $destination;
        $this->startOfTrip = $startOfTrip;
        $this->endOfTrip = $endOfTrip;
        $this->rating = $rating;
        $this->year = $year;
        $this->month = $month;
        $this->details = $details;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    public function getStartOfTrip()
    {
        return $this->startOfTrip;
    }

    public function setStartOfTrip($startOfTrip): void
    {
        $this->startOfTrip = $startOfTrip;
    }

    public function getEndOfTrip()
    {
        return $this->endOfTrip;
    }

    public function setEndOfTrip($endOfTrip): void
    {
        $this->endOfTrip = $endOfTrip;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function setMonth(string $month): void
    {
        $this->month = $month;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function setDetails(string $details): void
    {
        $this->details = $details;
    }

    public function getTransportTypeIds(): array
    {
        return $this->transportTypeIds;
    }

    public function setTransportTypeIds(array $transportTypeIds): void
    {
        $this->transportTypeIds = $transportTypeIds;
    }
}