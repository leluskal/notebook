<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\OutsideFood;

use App\Model\OutsideFood\OutsideFoodRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class OutsideFoodForm extends Control
{
    /**
     * @var OutsideFoodRepository
     */
    private $outsideFoodRepository;

    public function __construct(OutsideFoodRepository $outsideFoodRepository)
    {
        $this->outsideFoodRepository = $outsideFoodRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('food', 'Food')
             ->setRequired('The food is required');

        $form->addInteger('price', 'Price')
             ->setRequired('The price is required');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('food_delivery', 'Food Delivery?');

        $form->addCheckbox('drink', 'Drink');

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
            $this->outsideFoodRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of outside food is deleted', 'info');
            $this->getPresenter()->redirect('OutsideFood:default');
        }

        if ($values->id === '') {
            $this->outsideFoodRepository->create([
                'food' => $values->food,
                'price' => $values->price,
                'note' => $values->note !== '' ? $values->note : null,
                'food_delivery' => $values->food_delivery,
                'drink' => $values->drink,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of outside food is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'food' => $values->food,
                'price' => $values->price,
                'note' => $values->note !== '' ? $values->note : null,
                'food_delivery' => $values->food_delivery,
                'drink' => $values->drink,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->outsideFoodRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of outside food is updated', 'info');
        }

        $this->getPresenter()->redirect('OutsideFood:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/outsideFoodForm.latte');
        $template->render();
    }
}