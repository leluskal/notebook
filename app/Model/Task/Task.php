<?php
declare(strict_types=1);

namespace App\Model\Task;

use App\Model\TaskCategory\TaskCategory;

class Task
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $taskCategoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var string|null
     */
    private $link;

    /**
     * @var int
     */
    private $done;

    private $created;

    /**
     * @var int
     */
    private $year;

    /**
     * @var TaskCategory
     */
    private $taskCategory;

    public function __construct(int $taskCategoryId, string $name, int $done, $created, int $year)
    {
        $this->taskCategoryId = $taskCategoryId;
        $this->name = $name;
        $this->done = $done;
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

    public function getTaskCategoryId(): int
    {
        return $this->taskCategoryId;
    }

    public function setTaskCategoryId(int $taskCategoryId): void
    {
        $this->taskCategoryId = $taskCategoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getDone(): int
    {
        return $this->done;
    }

    public function setDone(int $done): void
    {
        $this->done = $done;
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

    public function getTaskCategory(): TaskCategory
    {
        return $this->taskCategory;
    }

    public function setTaskCategory(TaskCategory $taskCategory): void
    {
        $this->taskCategory = $taskCategory;
    }
}