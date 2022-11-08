<?php
declare(strict_types=1);

namespace App\Model\FurnishingLink;

use App\Model\Furnishing\FurnishingRepository;
use App\Model\Room\RoomRepository;

class FurnishingLinkService
{
    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    /**
     * @var RoomRepository
     */
    private $roomRepository;

    public function __construct(FurnishingRepository $furnishingRepository, RoomRepository $roomRepository)
    {
        $this->furnishingRepository = $furnishingRepository;
        $this->roomRepository = $roomRepository;
    }

    public function mapEntities(FurnishingLink $furnishingLink): FurnishingLink
    {
        $furnishing = $this->furnishingRepository->getById($furnishingLink->getFurnishingId());
        $room = $this->roomRepository->getById($furnishingLink->getRoomId());

        $furnishingLink->setFurnishing($furnishing);
        $furnishingLink->setRoom($room);

        return $furnishingLink;
    }

    public function mapEntitiesToArray(array $furnishingLinks): array
    {
        $mappedEntities = [];

        foreach ($furnishingLinks as $furnishingLink) {
            $mappedEntities[] = $this->mapEntities($furnishingLink);
        }

        return $mappedEntities;
    }
}