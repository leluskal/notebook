<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Room;

use App\Model\Room\RoomRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RoomForm extends Control
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Room')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->roomRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new room is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->roomRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The room is updated', 'info');
        }

        $this->getPresenter()->redirect('Room:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/roomForm.latte');
        $template->render();
    }
}