<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\DestinationType;

use App\Model\DestinationType\DestinationTypeRepository;

class DestinationTypeFormFactory
{
    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    public function __construct(DestinationTypeRepository $destinationTypeRepository)
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
    }

    public function create(): DestinationTypeForm
    {
        return new DestinationTypeForm($this->destinationTypeRepository);
    }
}