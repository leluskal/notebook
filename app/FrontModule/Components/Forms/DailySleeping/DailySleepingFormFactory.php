<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailySleeping;

use App\Model\DailySleeping\DailySleepingRepository;

class DailySleepingFormFactory
{
    /**
     * @var DailySleepingRepository
     */
    private $dailySleepingRepository;

    public function __construct(DailySleepingRepository $dailySleepingRepository)
    {
        $this->dailySleepingRepository = $dailySleepingRepository;
    }

    public function create(): DailySleepingForm
    {
        return new DailySleepingForm($this->dailySleepingRepository);
    }
}