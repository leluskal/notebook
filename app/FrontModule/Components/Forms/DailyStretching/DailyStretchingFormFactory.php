<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyStretching;

use App\Model\DailyStretching\DailyStretchingRepository;

class DailyStretchingFormFactory
{
    /**
     * @var DailyStretchingRepository
     */
    private $dailyStretchingRepository;

    public function __construct(DailyStretchingRepository $dailyStretchingRepository)
    {
        $this->dailyStretchingRepository = $dailyStretchingRepository;
    }

    public function create(): DailyStretchingForm
    {
        return new DailyStretchingForm($this->dailyStretchingRepository);
    }
}