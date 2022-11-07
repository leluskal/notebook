<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TransportType;

use App\Model\TransportType\TransportTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class TransportTypeForm extends Control
{
    /**
     * @var TransportTypeRepository
     */
    private $transportTypeRepository;

    public function __construct(TransportTypeRepository $transportTypeRepository)
    {
        $this->transportTypeRepository = $transportTypeRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Type')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->transportTypeRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new transport type is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->transportTypeRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The transport type is updated', 'info');
        }

        $this->getPresenter()->redirect('TransportType:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/transportTypeForm.latte');
        $template->render();
    }
}