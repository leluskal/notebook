<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\ShoppingCart;

use App\Model\ShoppingCart\ShoppingCartRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class ShoppingCartForm extends Control
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('shop', 'Shop')
             ->setRequired('The shop is required');

        $form->addInteger('price', 'Price')
             ->setRequired('The price is required');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addTextArea('note', 'Note');

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
            $this->shoppingCartRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of shopping cart is deleted', 'info');
            $this->getPresenter()->redirect('ShoppingCart:default');
        }

        if ($values->id === '') {
            $this->shoppingCartRepository->create([
                'shop' => $values->shop,
                'price' => $values->price,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'note' => $values->note !== '' ? $values->note : null,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of shopping cart is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'shop' => $values->shop,
                'price' => $values->price,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'note' => $values->note !== '' ? $values->note : null,
                'created' => $values->created,

            ];

            $this->shoppingCartRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of shopping cart is updated', 'info');
        }

        $this->getPresenter()->redirect('ShoppingCart:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/shoppingCartForm.latte');
        $template->render();
    }
}