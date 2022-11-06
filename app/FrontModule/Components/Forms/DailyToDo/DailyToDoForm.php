<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyToDo;

use App\Model\DailyToDo\DailyToDoRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyToDoForm extends Control
{
    /**
     * @var DailyToDoRepository
     */
    private $dailyToDoRepository;

    public function __construct(DailyToDoRepository $dailyToDoRepository)
    {
        $this->dailyToDoRepository = $dailyToDoRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('task', 'Task')
             ->setRequired('The task is required');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('done', 'Done');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addText('created', 'Created')
             ->setHtmlType('date')
             ->setRequired('The created is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->dailyToDoRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The task is deleted', 'info');
            $this->getPresenter()->redirect('DailyToDo:default');
        }

        if ($values->id === '') {
            $this->dailyToDoRepository->create([
                'task' => $values->task,
                'note' => $values->note !== '' ? $values->note : null,
                'done' => $values->done,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new task is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'task' => $values->task,
                'note' => $values->note !== '' ? $values->note : null,
                'done' => $values->done,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyToDoRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The task is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyToDo:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyToDoForm.latte');
        $template->render();
    }
}