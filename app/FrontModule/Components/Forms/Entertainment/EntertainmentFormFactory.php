<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Entertainment;

use App\Model\Entertainment\EntertainmentRepository;
use App\Model\EntertainmentType\EntertainmentTypeRepository;

class EntertainmentFormFactory
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    /**
     * @var EntertainmentRepository
     */
    private $entertainmentRepository;

    public function __construct(
        EntertainmentTypeRepository $entertainmentTypeRepository,
        EntertainmentRepository $entertainmentRepository
    )
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
        $this->entertainmentRepository = $entertainmentRepository;
    }

    public function create(): EntertainmentForm
    {
        return new EntertainmentForm($this->entertainmentTypeRepository, $this->entertainmentRepository);
    }
}