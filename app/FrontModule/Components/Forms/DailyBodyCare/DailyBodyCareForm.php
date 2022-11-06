<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyBodyCare;

use App\Model\DailyBodyCare\DailyBodyCareRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyBodyCareForm extends Control
{
    /**
     * @var DailyBodyCareRepository
     */
    private $dailyBodyCareRepository;

    public function __construct(DailyBodyCareRepository $dailyBodyCareRepository)
    {
        $this->dailyBodyCareRepository = $dailyBodyCareRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addCheckbox('face_morning', 'Washed Face In The Morning?');

        $form->addCheckbox('face_evening', 'Washed Face In The Evening?');

        $form->addCheckbox('teeth_morning', 'Washed Teeth In The Morning?');

        $form->addCheckbox('teeth_evening', 'Washed Teeth In The Evening?');

        $form->addCheckbox('dental_hygiene', 'Dental Hygiene?');

        $form->addCheckbox('body_care', 'Body Care?');

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
            $this->dailyBodyCareRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of daily body care is deleted', 'info');
            $this->getPresenter()->redirect('DailyBodyCare:default');
        }

        if ($values->id === '') {
            $this->dailyBodyCareRepository->create([
                'face_morning' => $values->face_morning,
                'face_evening' => $values->face_evening,
                'teeth_morning' => $values->teeth_morning,
                'teeth_evening' => $values->teeth_evening,
                'dental_hygiene' => $values->dental_hygiene,
                'body_care' => $values->body_care,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of daily body care is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'face_morning' => $values->face_morning,
                'face_evening' => $values->face_evening,
                'teeth_morning' => $values->teeth_morning,
                'teeth_evening' => $values->teeth_evening,
                'dental_hygiene' => $values->dental_hygiene,
                'body_care' => $values->body_care,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyBodyCareRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of daily body care is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyBodyCare:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyBodyCareForm.latte');
        $template->render();
    }
}