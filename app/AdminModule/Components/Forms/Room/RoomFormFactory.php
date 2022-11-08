<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Room;

use App\Model\Room\RoomRepository;

class RoomFormFactory
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function create(): RoomForm
    {
        return new RoomForm($this->roomRepository);
    }
}