<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyStretching;

use App\Model\DailyStretching\DailyStretchingRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyStretchingForm extends Control
{
    /**
     * @var DailyStretchingRepository
     */
    private $dailyStretchingRepository;

    public function __construct(DailyStretchingRepository $dailyStretchingRepository)
    {
        $this->dailyStretchingRepository = $dailyStretchingRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addInteger('stretch_time', 'Stretch Time');

        $form->addText('day_type', 'Free Day/Work');

        $form->addText('day_part', 'Day Part Of Stretching');

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
            $this->dailyStretchingRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of stretching is deleted', 'info');
            $this->getPresenter()->redirect('DailyStretching:default');
        }

        if ($values->id === '') {
            $this->dailyStretchingRepository->create([
                'stretch_time' => $values->stretch_time !== '' ? $values->stretch_time : null,
                'day_type' => $values->day_type !== '' ? $values->day_type : null,
                'day_part' => $values->day_part !== '' ? $values->day_part : null,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of stretching is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'stretch_time' => $values->stretch_time !== '' ? $values->stretch_time : null,
                'day_type' => $values->day_type !== '' ? $values->day_type : null,
                'day_part' => $values->day_part !== '' ? $values->day_part : null,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyStretchingRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of stretching is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyStretching:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyStretchingForm.latte');
        $template->render();
    }
}