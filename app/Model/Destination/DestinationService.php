<?php
declare(strict_types=1);

namespace App\Model\Destination;

use App\Model\DestinationType\DestinationTypeRepository;

class DestinationService
{
    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    public function __construct(DestinationTypeRepository $destinationTypeRepository)
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
    }

    public function mapEntity(Destination $destination): Destination
    {
        $destinationType = $this->destinationTypeRepository->getById($destination->getDestinationTypeId());

        $destination->setDestinationType($destinationType);

        return $destination;
    }

    public function mapEntityToArray(array $destinations): array
    {
        $mappedEntities = [];

        foreach ($destinations as $destination) {
            $mappedEntities[] = $this->mapEntity($destination);
        }

        return $mappedEntities;
    }
}