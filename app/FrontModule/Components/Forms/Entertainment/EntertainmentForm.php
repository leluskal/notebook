<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Entertainment;

use App\Model\Entertainment\EntertainmentRepository;
use App\Model\EntertainmentType\EntertainmentTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class EntertainmentForm extends Control
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    /**
     * @var EntertainmentRepository
     */
    private $entertainmentRepository;

    public function __construct(
        EntertainmentTypeRepository $entertainmentTypeRepository,
        EntertainmentRepository $entertainmentRepository
    )
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
        $this->entertainmentRepository = $entertainmentRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('entertainment_type_id', 'Type', $this->entertainmentTypeRepository->findAllForSelectBox())
             ->setPrompt('--Choose type--')
             ->setRequired('The type is required');

        $form->addText('month', 'Month')
            ->setRequired('The month is required');

        $form->addText('date', 'Date')
             ->setHtmlType('date')
             ->setRequired('The date is required');

        $form->addTextArea('details', 'Details')
             ->setRequired('The details are required');

        $form->addHidden('year');

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
            ->setPrompt('--Choose stars--');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->entertainmentRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of entertainment is deleted', 'info');
            $this->getPresenter()->redirect('Entertainment:default', ['month' => $values->month]);
        }

        if ($values->id === '') {
            $this->entertainmentRepository->create([
                'entertainment_type_id' => $values->entertainment_type_id,
                'month' => $values->month,
                'date' => $values->date,
                'details' => $values->details,
                'year' => $values->year,
                'rating' => $values->rating
            ]);
            $this->getPresenter()->flashMessage('The new record of entertainment is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'entertainment_type_id' => $values->entertainment_type_id,
                'month' => $values->month,
                'date' => $values->date,
                'details' => $values->details,
                'year' => $values->year,
                'rating' => $values->rating
            ];

            $this->entertainmentRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of entertainment is updated', 'info');
        }

        $this->getPresenter()->redirect('Entertainment:default', ['month' => $values->month]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/entertainmentForm.latte');
        $template->render();
    }
}