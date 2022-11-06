<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyMobile;

use App\Model\DailyMobile\DailyMobileRepository;

class DailyMobileFormFactory
{
    /**
     * @var DailyMobileRepository
     */
    private $dailyMobileRepository;

    public function __construct(DailyMobileRepository $dailyMobileRepository)
    {
        $this->dailyMobileRepository = $dailyMobileRepository;
    }

    public function create(): DailyMobileForm
    {
        return new DailyMobileForm($this->dailyMobileRepository);
    }
}