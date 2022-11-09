<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Task\TaskForm;
use App\FrontModule\Components\Forms\Task\TaskFormFactory;
use App\Model\Task\TaskRepository;
use App\Model\Task\TaskService;

class ApartmentTaskPresenter extends BasePresenter
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * @var TaskFormFactory
     */
    private $taskFormFactory;

    public function __construct(
        TaskRepository $taskRepository,
        TaskService $taskService,
        TaskFormFactory $taskFormFactory
    )
    {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
        $this->taskFormFactory = $taskFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }

    public function renderDefault()
    {
        $tasks = $this->taskRepository->findAll();
        $tasks = $this->taskService->mapEntityToArray($tasks);
        $this->template->tasks = $tasks;
    }

    public function createComponentTaskForm(): TaskForm
    {
        $form = $this->taskFormFactory->create();

        $form->onFinish[] = function (TaskForm $taskForm) {
            $this->redirect('ApartmentTask:default');
        };

        $form->onDelete[] = function (TaskForm $taskForm) {
            $this->redirect('ApartmentTask:default');
        };

        return $form;
    }

    public function renderCreate(int $year)
    {
        $this['taskForm']['form']['year']->setDefaultValue($year);
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
}