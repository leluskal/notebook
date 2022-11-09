<?php
declare(strict_types=1);

namespace App\Model\ApartmentList;

class ApartmentList
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
     * @var int
     */
    private $done;

    public function __construct(string $task, int $done)
    {
        $this->task = $task;
        $this->done = $done;
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

    public function getDone(): int
    {
        return $this->done;
    }

    public function setDone(int $done): void
    {
        $this->done = $done;
    }
}