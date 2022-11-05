<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyNumberOfStep;

use App\Model\DailyNumberOfStep\DailyNumberOfStepRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyNumberOfStepForm extends Control
{
    /**
     * @var DailyNumberOfStepRepository
     */
    private $dailyNumberOfStepRepository;

    public function __construct(DailyNumberOfStepRepository $dailyNumberOfStepRepository)
    {
        $this->dailyNumberOfStepRepository = $dailyNumberOfStepRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addInteger('number', 'Steps')
             ->setRequired('The number is required');

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
            $this->dailyNumberOfStepRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of steps is deleted', 'info');
            $this->getPresenter()->redirect();
        }

        if ($values->id === '') {
            $this->dailyNumberOfStepRepository->create([
                'number' => $values->number,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of steps is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'number' => $values->number,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyNumberOfStepRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of steps is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyWorkout:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyNumberOfStepForm.latte');
        $template->render();
    }
}