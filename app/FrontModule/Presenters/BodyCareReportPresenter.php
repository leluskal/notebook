<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\DailyBodyCare\DailyBodyCareRepository;

class BodyCareReportPresenter extends BasePresenter
{
    /**
     * @var DailyBodyCareRepository
     */
   private $dailyBodyCareRepository;

    public function __construct(DailyBodyCareRepository $dailyBodyCareRepository)
    {
        $this->dailyBodyCareRepository = $dailyBodyCareRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function renderDefault()
    {
        $this->template->months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $this->template->numberOfRecords = $this->dailyBodyCareRepository->getNumberOfRecordsForAllMonths((int) $this->year);
        $this->template->totalData = $this->dailyBodyCareRepository->getPercentageForAllMonths((int) $this->year);

        $this->template->year = $this->year;
    }


}