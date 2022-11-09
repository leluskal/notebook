<?php
declare(strict_types=1);

namespace App\Model\WeeklyToDo;

class WeeklyToDo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $task;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int
     */
    private $done;

    /**
     * @var int
     */
    private $weekNumber;

    /**
     * @var int
     */
    private $year;

    public function __construct(string $task, int $done, int $weekNumber, int $year)
    {
        $this->task = $task;
        $this->done = $done;
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

    public function getTask(): string
    {
        return $this->task;
    }

    public function setTask(string $task): void
    {
        $this->task = $task;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getDone(): int
    {
        return $this->done;
    }

    public function setDone(int $done): void
    {
        $this->done = $done;
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