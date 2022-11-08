<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\FurnishingLink;

use App\Model\Furnishing\FurnishingRepository;
use App\Model\FurnishingLink\FurnishingLinkRepository;
use App\Model\Room\RoomRepository;

class FurnishingLinkFormFactory
{
    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * @var FurnishingLinkRepository
     */
    private $furnishingLinkRepository;

    public function __construct(
        FurnishingRepository $furnishingRepository,
        RoomRepository $roomRepository,
        FurnishingLinkRepository $furnishingLinkRepository
    )
    {
        $this->furnishingRepository = $furnishingRepository;
        $this->roomRepository = $roomRepository;
        $this->furnishingLinkRepository = $furnishingLinkRepository;
    }

    public function create(): FurnishingLinkForm
    {
        return new FurnishingLinkForm($this->furnishingRepository, $this->roomRepository, $this->furnishingLinkRepository);
    }
}