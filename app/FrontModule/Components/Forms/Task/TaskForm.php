<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Task;

use App\Model\Task\TaskRepository;
use App\Model\TaskCategory\TaskCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class TaskForm extends Control
{
    use SmartObject;

    /**
     * @var array
     */
    public $onFinish;

    /**
     * @var array
     */
    public $onDelete;

    private $day;

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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('task_category_id', 'Category', $this->taskCategoryRepository->findAllForSelectBox())
             ->setPrompt('--Choose category--')
             ->setRequired('The category is required');

        $form->addText('name', 'Task')
             ->setRequired('The name is required');

        $form->addTextArea('note', 'Note');

        $form->addText('link', 'Link');

        $form->addCheckbox('done', 'Done');

        $form->addText('created', 'Created')
            ->setHtmlType('date')
            ->setRequired('The created is required');

        $form->addHidden('year', 'Year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
            ->setValidationScope([$form['id'], $form['created']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->taskRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The task is deleted', 'info');
            $this->onDelete($this);
        }

        if ($values->id === '') {
            $this->taskRepository->create([
                'task_category_id' => $values->task_category_id,
                'name' => $values->name,
                'note' => $values->note !== '' ? $values->note : null,
                'link' => $values->link !== '' ? $values->link : null,
                'done' => $values->done,
                'created' => $values->created,
                'year' => $values->year
            ]);
            $this->getPresenter()->flashMessage('The new task is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'task_category_id' => $values->task_category_id,
                'name' => $values->name,
                'note' => $values->note !== '' ? $values->note : null,
                'link' => $values->link !== '' ? $values->link : null,
                'done' => $values->done,
                'created' => $values->created,
                'year' => $values->year
            ];

            $this->taskRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The task is updated', 'info');
        }

        $this->day = $values->created;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/taskForm.latte');
        $template->render();
    }

    public function getDay()
    {
        return $this->day;
    }
}