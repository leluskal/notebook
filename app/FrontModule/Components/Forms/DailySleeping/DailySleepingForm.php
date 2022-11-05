<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailySleeping;

use App\Model\DailySleeping\DailySleepingRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailySleepingForm extends Control
{
    /**
     * @var DailySleepingRepository
     */
    private $dailySleepingRepository;

    public function __construct(DailySleepingRepository $dailySleepingRepository)
    {
        $this->dailySleepingRepository = $dailySleepingRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('time_go_to_bed', 'Go To Bed')
             ->setRequired('The time is required')
             ->setHtmlType('datetime-local');

        $form->addText('time_get_up', 'Get Up')
            ->setRequired('The time is required')
            ->setHtmlType('datetime-local');

        $form->addText('day_type', 'Free Day/Work')
             ->setRequired('The day type is required');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('illness', 'Illness');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addText('created', 'Created')
             ->setRequired('The created is required')
             ->setHtmlType('date');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->dailySleepingRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of sleeping is deleted', 'info');
            $this->getPresenter()->redirect('DailySleeping:default');
        }

        if ($values->id === '') {
            $this->dailySleepingRepository->create([
                'time_go_to_bed' => $values->time_go_to_bed,
                'time_get_up' => $values->time_get_up,
                'day_type' => $values->day_type,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of sleeping is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'time_go_to_bed' => $values->time_go_to_bed,
                'time_get_up' => $values->time_get_up,
                'day_type' => $values->day_type,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailySleepingRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of sleeping is updated', 'info');
        }

        $this->getPresenter()->redirect('DailySleeping:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailySleepingForm.latte');
        $template->render();
    }
}