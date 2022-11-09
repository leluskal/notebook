<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Task;

use App\Model\Task\TaskRepository;
use App\Model\TaskCategory\TaskCategoryRepository;

class TaskFormFactory
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepository, TaskRepository $taskRepository)
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
        $this->taskRepository = $taskRepository;
    }
    public function create(): TaskForm
    {
        return new TaskForm($this->taskCategoryRepository, $this->taskRepository);
    }
}