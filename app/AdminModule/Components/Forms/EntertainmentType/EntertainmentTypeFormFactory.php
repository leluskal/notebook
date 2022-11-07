<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\EntertainmentType;

use App\Model\EntertainmentType\EntertainmentTypeRepository;

class EntertainmentTypeFormFactory
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    public function __construct(EntertainmentTypeRepository $entertainmentTypeRepository)
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
    }

    public function create(): EntertainmentTypeForm
    {
        return new EntertainmentTypeForm($this->entertainmentTypeRepository);
    }
}