<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyBodyWeight;

use App\Model\DailyBodyWeight\DailyBodyWeightRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyBodyWeightForm extends Control
{
    /**
     * @var DailyBodyWeightRepository
     */
    private $dailyBodyWeightRepository;

    public function __construct(DailyBodyWeightRepository $dailyBodyWeightRepository)
    {
        $this->dailyBodyWeightRepository = $dailyBodyWeightRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('number', 'Weight')
            ->setRequired('The number is required')
            ->addRule(Form::FLOAT, 'Write the number');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addText('created', 'Created')
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
            $this->dailyBodyWeightRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is delete', 'info');
            $this->getPresenter()->redirect('DailyEating:default');
        }

        if ($values->id === '') {
            $this->dailyBodyWeightRepository->create([
                'number' => $values->number,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of weight is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'number' => $values->number,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyBodyWeightRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of weight is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyEating:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyBodyWeightForm.latte');
        $template->render();
    }
}