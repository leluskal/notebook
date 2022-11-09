<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\TaskCategory\TaskCategoryForm;
use App\AdminModule\Components\Forms\TaskCategory\TaskCategoryFormFactory;
use App\Model\TaskCategory\TaskCategoryRepository;
use App\Presenters\BaseAuthorizedPresenter;

class TaskCategoryPresenter extends BaseAuthorizedPresenter
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    /**
     * @var TaskCategoryFormFactory
     */
    private $taskCategoryFormFactory;


    public function __construct(
        TaskCategoryRepository $taskCategoryRepository,
        TaskCategoryFormFactory $taskCategoryFormFactory
    )
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
        $this->taskCategoryFormFactory = $taskCategoryFormFactory;
    }

    public function renderDefault()
    {
        $this->template->taskCategories = $this->taskCategoryRepository->findAll();
    }

    public function createComponentTaskCategoryForm(): TaskCategoryForm
    {
        return $this->taskCategoryFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $taskCategory = $this->taskCategoryRepository->getById($id);
        $this->template->taskCategory = $taskCategory;

        $this['taskCategoryForm']['form']['id']->setDefaultValue($taskCategory->getId());
        $this['taskCategoryForm']['form']['name']->setDefaultValue($taskCategory->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteTaskCategory(int $id)
    {
        $this->taskCategoryRepository->deleteById($id);

        $this->flashMessage('The task category is deleted', 'info');
        $this->redirect('TaskCategory:default');
    }
}