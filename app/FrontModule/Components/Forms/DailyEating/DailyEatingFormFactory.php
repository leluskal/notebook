<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyEating;

use App\Model\DailyEating\DailyEatingRepository;

class DailyEatingFormFactory
{
    /**
     * @var DailyEatingRepository
     */
    private $dailyEatingRepository;

    public function __construct(DailyEatingRepository $dailyEatingRepository)
    {
        $this->dailyEatingRepository = $dailyEatingRepository;
    }

    public function create(): DailyEatingForm
    {
        return new DailyEatingForm($this->dailyEatingRepository);
    }
}