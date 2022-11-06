<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\DailyProgramming\DailyProgrammingRepository;

class ProgrammingTimeReportPresenter extends BasePresenter
{
    /**
     * @var DailyProgrammingRepository
     */
    private $dailyProgrammingRepository;

    public function __construct(DailyProgrammingRepository $dailyProgrammingRepository)
    {
        $this->dailyProgrammingRepository = $dailyProgrammingRepository;
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

        $this->template->numberOfRecords = $this->dailyProgrammingRepository->getNumberOfRecordsForAllMonths((int) $this->year);
        $this->template->totalData = $this->dailyProgrammingRepository->getTotalProgrammingTimeForAllMonths((int) $this->year);

        $this->template->year = $this->year;
    }

}