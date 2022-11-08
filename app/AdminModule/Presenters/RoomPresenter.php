<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Room\RoomForm;
use App\AdminModule\Components\Forms\Room\RoomFormFactory;
use App\Model\Room\RoomRepository;
use App\Presenters\BaseAuthorizedPresenter;

class RoomPresenter extends BaseAuthorizedPresenter
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * @var RoomFormFactory
     */
    private $roomFormFactory;

    public function __construct(
        RoomRepository $roomRepository,
        RoomFormFactory $roomFormFactory
    )
    {
        $this->roomRepository = $roomRepository;
        $this->roomFormFactory = $roomFormFactory;
    }

    public function renderDefault()
    {
        $this->template->rooms = $this->roomRepository->findAll();
    }

    public function createComponentRoomForm(): RoomForm
    {
        return $this->roomFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $room = $this->roomRepository->getById($id);

        $this->template->room = $room;

        $this['roomForm']['form']['id']->setDefaultValue($room->getId());
        $this['roomForm']['form']['name']->setDefaultValue($room->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteRoom(int $id)
    {
        $this->roomRepository->deleteById($id);

        $this->flashMessage('The room is deleted', 'info');
        $this->redirect('Room:default');
    }
}