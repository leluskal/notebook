<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyProgramming;

use App\Model\DailyProgramming\DailyProgrammingRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyProgrammingForm extends Control
{
    /**
     * @var DailyProgrammingRepository
     */
    private $dailyProgrammingRepository;

    public function __construct(DailyProgrammingRepository $dailyProgrammingRepository)
    {
        $this->dailyProgrammingRepository = $dailyProgrammingRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addInteger('programming_duration', 'Programming Duration');

        $form->addText('day_type', 'Free Day/Work');

        $form->addText('day_part', 'Day Part Of Programming');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('illness', 'Illness?');

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
            $this->dailyProgrammingRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of programming is saved', 'success');
            $this->getPresenter()->redirect('DailyProgramming:default');
        }

        if ($values->id === '') {
            $this->dailyProgrammingRepository->create([
                'programming_duration' => $values->programming_duration !== '' ? $values->programming_duration : null,
                'day_type' => $values->day_type !== '' ? $values->day_type : null,
                'day_part' => $values->day_part !== '' ? $values->day_part : null,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created,
            ]);
            $this->getPresenter()->flashMessage('The new record of programming is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'programming_duration' => $values->programming_duration,
                'day_type' => $values->day_type,
                'day_part' => $values->day_part,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyProgrammingRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of programming is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyProgramming:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyProgrammingForm.latte');
        $template->render();
    }
}