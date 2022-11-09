<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Task\TaskForm;
use App\FrontModule\Components\Forms\Task\TaskFormFactory;
use App\Model\Task\TaskRepository;
use App\Model\Task\TaskService;
use App\Model\TaskCategory\TaskCategoryRepository;

class TaskListPresenter extends BasePresenter
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

    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    public function __construct(
        TaskRepository $taskRepository,
        TaskService $taskService,
        TaskFormFactory $taskFormFactory,
        TaskCategoryRepository $taskCategoryRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
        $this->taskFormFactory = $taskFormFactory;
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function renderDefault(int $taskCategoryId = null)
    {
        $this->template->taskCategories = $this->taskCategoryRepository->findAll();

        $tasks = $this->taskRepository->findAllByTaskCategoryIdAndYear((int) $taskCategoryId, (int) $this->year);
        $tasks = $this->taskService->mapEntityToArray($tasks);
        $this->template->tasks = $tasks;

        $this->template->taskCategory = null;

        if ($taskCategoryId !== null) {
            $this->template->tasks = $tasks;
            $this->template->taskCategory = $this->taskCategoryRepository->getById($taskCategoryId);
        }

        $this->template->year = $this->year;
    }

    public function createComponentTaskForm(): TaskForm
    {
        $form = $this->taskFormFactory->create();

        $form->onFinish[] = function (TaskForm $taskForm) {
            $this->redirect('TaskList:default');
        };

        $form->onDelete[] = function (TaskForm $taskForm) {
            $this->redirect('TaskList:default');
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