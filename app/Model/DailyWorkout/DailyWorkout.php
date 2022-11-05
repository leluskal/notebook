<?php
declare(strict_types=1);

namespace App\Model\DailyWorkout;

class DailyWorkout
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $fitnessInstructorId;

    /**
     * @var int|null
     */
    private $workoutTime;

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
        int $fitnessInstructorId,
        int $illness,
        int $dayNumber,
        int $month,
        int $year,
        $created
    )
    {
        $this->fitnessInstructorId = $fitnessInstructorId;
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

    public function getFitnessInstructorId(): int
    {
        return $this->fitnessInstructorId;
    }

    public function setFitnessInstructorId(int $fitnessInstructorId): void
    {
        $this->fitnessInstructorId = $fitnessInstructorId;
    }

    public function getWorkoutTime(): ?int
    {
        return $this->workoutTime;
    }

    public function setWorkoutTime(?int $workoutTime): void
    {
        $this->workoutTime = $workoutTime;
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