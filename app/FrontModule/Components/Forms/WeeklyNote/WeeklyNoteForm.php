<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\WeeklyNote;

use App\Model\WeeklyNote\WeeklyNoteRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class WeeklyNoteForm extends Control
{
    /**
     * @var WeeklyNoteRepository
     */
    private $weeklyNoteRepository;

    public function __construct(WeeklyNoteRepository $weeklyNoteRepository)
    {
        $this->weeklyNoteRepository = $weeklyNoteRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addTextArea('plan', 'Week Plan')
             ->setRequired('The plan is required');

        $form->addTextArea('reality', 'Week Reality');

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
            ->setPrompt('--Choose stars--');

        $form->addInteger('week_number', 'Week Number')
             ->setRequired('The week number is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->weeklyNoteRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is deleted', 'info');
            $this->getPresenter()->redirect('WeekPlan:detailWeek', ['weekNumber' => $values->week_number]);
        }

        if ($values->id === '') {
            $this->weeklyNoteRepository->create([
                'plan' => $values->plan,
                'reality' => $values->reality !== '' ? $values->reality : null,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'week_number' => $values->week_number,
                'year' => $values->year
            ]);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'plan' => $values->plan,
                'reality' => $values->reality !== '' ? $values->reality : null,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'week_number' => $values->week_number,
                'year' => $values->year
            ];

            $this->weeklyNoteRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->getPresenter()->redirect('WeekPlan:detailWeek', ['weekNumber' => $values->week_number]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/weeklyNoteForm.latte');
        $template->render();
    }
}