<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TaskCategory;

use App\Model\TaskCategory\TaskCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class TaskCategoryForm extends Control
{
    /**
     * @var TaskCategoryRepository
     */
    private $taskCategoryRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepository)
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Category')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->taskCategoryRepository->create([
                'name' => $values->name,
            ]);
            $this->getPresenter()->flashMessage('The new task category is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
            ];

            $this->taskCategoryRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The task category is updated','info');
        }

        $this->getPresenter()->redirect('TaskCategory:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/taskCategoryForm.latte');
        $template->render();
    }
}