<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TaskCategory;

use App\Model\TaskCategory\TaskCategoryRepository;

class TaskCategoryFormFactory
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepository)
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    public function create(): TaskCategoryForm
    {
        return new TaskCategoryForm($this->taskCategoryRepository);
    }
}