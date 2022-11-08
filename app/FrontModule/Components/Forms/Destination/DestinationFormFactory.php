<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Destination;

use App\Model\Destination\DestinationRepository;
use App\Model\DestinationType\DestinationTypeRepository;

class DestinationFormFactory
{
    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    /**
     * @var DestinationRepository
     */
    private $destinationRepository;

    public function __construct(
        DestinationTypeRepository $destinationTypeRepository,
        DestinationRepository $destinationRepository
    )
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
        $this->destinationRepository = $destinationRepository;
    }

    public function create(): DestinationForm
    {
        return new DestinationForm($this->destinationTypeRepository, $this->destinationRepository);
    }
}