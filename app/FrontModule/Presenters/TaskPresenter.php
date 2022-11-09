<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Task\TaskForm;
use App\FrontModule\Components\Forms\Task\TaskFormFactory;
use App\Model\Task\TaskRepository;
use App\Model\TaskCategory\TaskCategoryRepository;

class TaskPresenter extends BasePresenter
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var TaskFormFactory
     */
    private $taskFormFactory;

    public function __construct(
        TaskCategoryRepository $taskCategoryRepository,
        TaskRepository $taskRepository,
        TaskFormFactory $taskFormFactory
    )
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
        $this->taskRepository = $taskRepository;
        $this->taskFormFactory = $taskFormFactory;
    }

    public function createComponentTaskForm(): TaskForm
    {
        $form = $this->taskFormFactory->create();

        $form->onFinish[] = function (TaskForm $taskForm) use ($form) {
            $this->redirect('WeekPlan:detailDay', ['day' => $form->getDay()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $task = $this->taskRepository->getById($id);

        $this->template->task = $task;

        $this['taskForm']['form']['id']->setDefaultValue($task->getId());
        $this['taskForm']['form']['task_category_id']->setDefaultValue($task->getTaskCategoryId());
        $this['taskForm']['form']['name']->setDefaultValue($task->getName());
        $this['taskForm']['form']['note']->setDefaultValue($task->getNote());
        $this['taskForm']['form']['link']->setDefaultValue($task->getLink());
        $this['taskForm']['form']['done']->setDefaultValue($task->getDone());
        $this['taskForm']['form']['created']->setDefaultValue($task->getCreated()->format('Y-m-d'));
        $this['taskForm']['form']['year']->setDefaultValue($task->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['taskForm']['form']['year']->setDefaultValue($year);
    }

}