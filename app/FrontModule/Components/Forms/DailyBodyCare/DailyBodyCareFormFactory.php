<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyBodyCare;

use App\Model\DailyBodyCare\DailyBodyCareRepository;

class DailyBodyCareFormFactory
{
    /**
     * @var DailyBodyCareRepository
     */
    private $dailyBodyCareRepository;

    public function __construct(DailyBodyCareRepository $dailyBodyCareRepository)
    {
        $this->dailyBodyCareRepository = $dailyBodyCareRepository;
    }

    public function create(): DailyBodyCareForm
    {
        return new DailyBodyCareForm($this->dailyBodyCareRepository);
    }
}