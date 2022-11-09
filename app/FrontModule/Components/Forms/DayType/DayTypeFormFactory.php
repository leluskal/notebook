<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DayType;

use App\Model\DayType\DayTypeRepository;

class DayTypeFormFactory
{
    /**
     * @var DayTypeRepository
     */
    private $dayTypeRepository;

    public function __construct(DayTypeRepository $dayTypeRepository)
    {
        $this->dayTypeRepository = $dayTypeRepository;
    }

    public function create(): DayTypeForm
    {
        return new DayTypeForm($this->dayTypeRepository);
    }
}