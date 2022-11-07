<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\EntertainmentType;

use App\Model\EntertainmentType\EntertainmentTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class EntertainmentTypeForm extends Control
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    public function __construct(EntertainmentTypeRepository $entertainmentTypeRepository)
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
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
            $this->entertainmentTypeRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new entertainment type is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->entertainmentTypeRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The entertainment type is updated', 'info');
        }

        $this->getPresenter()->redirect('EntertainmentType:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/entertainmentTypeForm.latte');
        $template->render();
    }
}