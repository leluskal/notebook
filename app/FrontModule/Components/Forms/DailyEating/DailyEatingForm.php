<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyEating;

use App\Model\DailyEating\DailyEatingRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyEatingForm extends Control
{
    /**
     * @var DailyEatingRepository
     */
    private $dailyEatingRepository;

    public function __construct(DailyEatingRepository $dailyEatingRepository)
    {
        $this->dailyEatingRepository = $dailyEatingRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addInteger('calorie_number', 'Calories Number')
             ->setRequired('The calorie number is required');

        $form->addText('day_type', 'Free Day/Work')
            ->setRequired('The day type is required');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('calorie_estimate', 'Calorie Estimate?');

        $form->addCheckbox('outside_food', 'Outside Food?');

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
            $this->dailyEatingRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of eating is deleted', 'info');
            $this->getPresenter()->redirect('DailyEating:default');
        }

        if ($values->id === '') {
            $this->dailyEatingRepository->create([
                'calorie_number' => $values->calorie_number,
                'day_type' => $values->day_type,
                'note' => $values->note !== '' ? $values->note : null,
                'calorie_estimate' => $values->calorie_estimate,
                'outside_food' => $values->outside_food,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of eating is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'calorie_number' => $values->calorie_number,
                'day_type' => $values->day_type,
                'note' => $values->note !== '' ? $values->note : null,
                'calorie_estimate' => $values->calorie_estimate,
                'outside_food' => $values->outside_food,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyEatingRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of eating is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyEating:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyEatingForm.latte');
        $template->render();
    }

}