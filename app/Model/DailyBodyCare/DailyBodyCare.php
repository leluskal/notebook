<?php
declare(strict_types=1);

namespace App\Model\DailyBodyCare;

class DailyBodyCare
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $faceMorning;

    /**
     * @var int
     */
    private $faceEvening;

    /**
     * @var int
     */
    private $teethMorning;

    /**
     * @var int
     */
    private $teethEvening;

    /**
     * @var int
     */
    private $dentalHygiene;

    /**
     * @var int
     */
    private $bodyCare;

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
        int $faceMorning,
        int $faceEvening,
        int $teethMorning,
        int $teethEvening,
        int $dentalHygiene,
        int $bodyCare,
        int $dayNumber,
        int $month,
        int $year,
            $created
    )
    {
        $this->faceMorning = $faceMorning;
        $this->faceEvening = $faceEvening;
        $this->teethMorning = $teethMorning;
        $this->teethEvening = $teethEvening;
        $this->dentalHygiene = $dentalHygiene;
        $this->bodyCare = $bodyCare;
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

    public function getFaceMorning(): int
    {
        return $this->faceMorning;
    }

    public function setFaceMorning(int $faceMorning): void
    {
        $this->faceMorning = $faceMorning;
    }

    public function getFaceEvening(): int
    {
        return $this->faceEvening;
    }

    public function setFaceEvening(int $faceEvening): void
    {
        $this->faceEvening = $faceEvening;
    }

    public function getTeethMorning(): int
    {
        return $this->teethMorning;
    }

    public function setTeethMorning(int $teethMorning): void
    {
        $this->teethMorning = $teethMorning;
    }

    public function getTeethEvening(): int
    {
        return $this->teethEvening;
    }

    public function setTeethEvening(int $teethEvening): void
    {
        $this->teethEvening = $teethEvening;
    }

    public function getDentalHygiene(): int
    {
        return $this->dentalHygiene;
    }

    public function setDentalHygiene(int $dentalHygiene): void
    {
        $this->dentalHygiene = $dentalHygiene;
    }

    public function getBodyCare(): int
    {
        return $this->bodyCare;
    }

    public function setBodyCare(int $bodyCare): void
    {
        $this->bodyCare = $bodyCare;
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