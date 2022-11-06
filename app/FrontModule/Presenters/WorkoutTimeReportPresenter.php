<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\DailyWorkout\DailyWorkoutRepository;

class WorkoutTimeReportPresenter extends BasePresenter
{
    /**
     * @var DailyWorkoutRepository
     */
    private $dailyWorkoutRepository;

    public function __construct(DailyWorkoutRepository $dailyWorkoutRepository)
    {
        $this->dailyWorkoutRepository = $dailyWorkoutRepository;
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

        $this->template->numberOfRecords = $this->dailyWorkoutRepository->getNumberOfRecordsForAllMonths((int) $this->year);
        $this->template->totalData = $this->dailyWorkoutRepository->getTotalWorkoutTimeForAllMonths((int) $this->year);

        $this->template->year = $this->year;
    }

}