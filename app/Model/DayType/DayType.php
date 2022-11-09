<?php
declare(strict_types=1);

namespace App\Model\DayType;

class DayType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $workDay;

    private $created;

    /**
     * @var int
     */
    private $year;

    public function __construct(string $name, int $workDay, $created, int $year)
    {
        $this->name = $name;
        $this->workDay = $workDay;
        $this->created = $created;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getWorkDay(): int
    {
        return $this->workDay;
    }

    public function setWorkDay(int $workDay): void
    {
        $this->workDay = $workDay;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): void
    {
        $this->created = $created;
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