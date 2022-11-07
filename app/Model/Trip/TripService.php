<?php
declare(strict_types=1);

namespace App\Model\Trip;

use App\Model\TripTransport\TripTransportRepository;

class TripService
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * @var TripTransportRepository
     */
    private $tripTransportRepository;

    public function __construct(TripRepository $tripRepository, TripTransportRepository $tripTransportRepository)
    {
        $this->tripRepository = $tripRepository;
        $this->tripTransportRepository = $tripTransportRepository;
    }

    public function fillTransportTypeIds(array $tripsByMonth): array
    {
        $returnArray = [];

        /** @var Trip $trip */
        foreach ($tripsByMonth as $month => $trips) {
            foreach ($trips as $trip) {
                $transportTypeIds = $this->tripTransportRepository->getAllTransportIdsByTripId($trip->getId());
                $trip->setTransportTypeIds($transportTypeIds);

                $returnArray[$month][] = $trip;
            }
        }

        return $returnArray;
    }

}