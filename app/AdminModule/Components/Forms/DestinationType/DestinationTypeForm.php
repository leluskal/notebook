<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\DestinationType;

use App\Model\DestinationType\DestinationTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DestinationTypeForm extends Control
{
    /**
     * @var DestinationTypeRepository
     */
   private $destinationTypeRepository;

    public function __construct(DestinationTypeRepository $destinationTypeRepository)
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Destination Type')
             ->setRequired('The type is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->destinationTypeRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new destination type is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->destinationTypeRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of destination type is updated', 'info');
        }

        $this->getPresenter()->redirect('DestinationType:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/destinationTypeForm.latte');
        $template->render();
    }
}