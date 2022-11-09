<?php
declare(strict_types=1);

namespace App\Model\Task;

use App\Model\TaskCategory\TaskCategoryRepository;

class TaskService
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepository)
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    public function mapEntity(Task $task): Task
    {
        $taskCategory = $this->taskCategoryRepository->getById($task->getTaskCategoryId());

        $task->setTaskCategory($taskCategory);

        return $task;
    }

    public function mapEntityToArray(array $tasks): array
    {
        $mappedEntities = [];

        foreach ($tasks as $task) {
            $mappedEntities[] = $this->mapEntity($task);
        }

        return $mappedEntities;
    }
}