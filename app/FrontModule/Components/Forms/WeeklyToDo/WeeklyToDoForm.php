<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\WeeklyToDo;

use App\Model\WeeklyToDo\WeeklyToDoRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class WeeklyToDoForm extends Control
{
    /**
     * @var WeeklyToDoRepository
     */
    private $weeklyToDoRepository;

    public function __construct(WeeklyToDoRepository $weeklyToDoRepository)
    {
        $this->weeklyToDoRepository = $weeklyToDoRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('task', 'Task')
             ->setRequired('The task is required');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('done', 'Done');

        $form->addInteger('week_number', 'Week Number')
             ->setRequired('The week number is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
            ->setValidationScope([$form['id'], $form['week_number']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->weeklyToDoRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The task is deleted', 'info');
            $this->getPresenter()->redirect('WeekPlan:detailWeek', ['weekNumber' => $values->week_number]);
        }

        if ($values->id === '') {
            $this->weeklyToDoRepository->create([
                'task' => $values->task,
                'note' => $values->note !== '' ? $values->note : null,
                'done' => $values->done,
                'week_number' => $values->week_number,
                'year' => $values->year
            ]);
            $this->getPresenter()->flashMessage('The new task is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'task' => $values->task,
                'note' => $values->note !== '' ? $values->note : null,
                'done' => $values->done,
                'week_number' => $values->week_number,
                'year' => $values->year
            ];

            $this->weeklyToDoRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The task is updated', 'info');
        }

        $this->getPresenter()->redirect('WeekPlan:detailWeek', ['weekNumber' => $values->week_number]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/weeklyToDoForm.latte');
        $template->render();
    }
}