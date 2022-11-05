<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyNumberOfStep;

use App\Model\DailyNumberOfStep\DailyNumberOfStepRepository;

class DailyNumberOfStepFormFactory
{
    /**
     * @var DailyNumberOfStepRepository
     */
    private $dailyNumberOfStepRepository;

    public function __construct(DailyNumberOfStepRepository $dailyNumberOfStepRepository)
    {
        $this->dailyNumberOfStepRepository = $dailyNumberOfStepRepository;
    }

    public function create(): DailyNumberOfStepForm
    {
        return new DailyNumberOfStepForm($this->dailyNumberOfStepRepository);
    }
}