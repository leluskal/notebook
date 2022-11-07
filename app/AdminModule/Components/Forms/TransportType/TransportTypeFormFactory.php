<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\TransportType;

use App\Model\TransportType\TransportTypeRepository;

class TransportTypeFormFactory
{
    /**
     * @var TransportTypeRepository
     */
    private $transportTypeRepository;

    public function __construct(TransportTypeRepository $transportTypeRepository)
    {
        $this->transportTypeRepository = $transportTypeRepository;
    }

    public function create(): TransportTypeForm
    {
        return new TransportTypeForm($this->transportTypeRepository);
    }
}