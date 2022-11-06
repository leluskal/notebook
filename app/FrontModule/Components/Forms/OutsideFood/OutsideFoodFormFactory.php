<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\OutsideFood;

use App\Model\OutsideFood\OutsideFoodRepository;

class OutsideFoodFormFactory
{
    /**
     * @var OutsideFoodRepository
     */
    private $nonCookedFoodRecordRepository;

    public function __construct(OutsideFoodRepository $nonCookedFoodRecordRepository)
    {
        $this->nonCookedFoodRecordRepository = $nonCookedFoodRecordRepository;
    }

    public function create(): OutsideFoodForm
    {
        return new OutsideFoodForm($this->nonCookedFoodRecordRepository);
    }
}