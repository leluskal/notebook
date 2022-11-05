<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyProgramming;

use App\Model\DailyProgramming\DailyProgrammingRepository;

class DailyProgrammingFormFactory
{
    /**
     * @var DailyProgrammingRepository
     */
    private $dailyProgrammingRepository;

    public function __construct(DailyProgrammingRepository $dailyProgrammingRepository)
    {
        $this->dailyProgrammingRepository = $dailyProgrammingRepository;
    }

    public function create(): DailyProgrammingForm
    {
        return new DailyProgrammingForm($this->dailyProgrammingRepository);
    }
}