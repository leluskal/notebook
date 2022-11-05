<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyBodyWeight;

use App\Model\DailyBodyWeight\DailyBodyWeightRepository;

class DailyBodyWeightFormFactory
{
    /**
     * @var DailyBodyWeightRepository
     */
    private $dailyBodyWeightRepository;

    public function __construct(DailyBodyWeightRepository $dailyBodyWeightRepository)
    {
        $this->dailyBodyWeightRepository = $dailyBodyWeightRepository;
    }

    public function create(): DailyBodyWeightForm
    {
        return new DailyBodyWeightForm($this->dailyBodyWeightRepository);
    }

}