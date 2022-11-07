<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Trip;

use App\Model\Destination\DestinationRepository;
use App\Model\TransportType\TransportTypeRepository;
use App\Model\Trip\TripRepository;
use App\Model\TripTransport\TripTransportRepository;

class TripFormFactory
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * @var TransportTypeRepository
     */
    private $transportTypeRepository;

    /**
     * @var TripTransportRepository
     */
    private $tripTransportRepository;

    public function __construct(
        TripRepository $tripRepository,
        TransportTypeRepository $transportTypeRepository,
        TripTransportRepository $tripTransportRepository
    )
    {
        $this->tripRepository = $tripRepository;
        $this->transportTypeRepository = $transportTypeRepository;
        $this->tripTransportRepository = $tripTransportRepository;
    }

    public function create(): TripForm
    {
        return new TripForm(
            $this->tripRepository,
            $this->transportTypeRepository,
            $this->tripTransportRepository
        );
    }
}