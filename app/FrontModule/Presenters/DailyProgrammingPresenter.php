<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyProgramming\DailyProgrammingForm;
use App\FrontModule\Components\Forms\DailyProgramming\DailyProgrammingFormFactory;
use App\Model\DailyProgramming\DailyProgrammingRepository;

class DailyProgrammingPresenter extends BasePresenter
{
    /**
     * @var DailyProgrammingRepository
     */
    private $dailyProgrammingRepository;

    /**
     * @var DailyProgrammingFormFactory
     */
    private $dailyProgrammingFormFactory;

    public function __construct(
        DailyProgrammingRepository $dailyProgrammingRepository,
        DailyProgrammingFormFactory $dailyProgrammingFormFactory
    )
    {
        $this->dailyProgrammingRepository = $dailyProgrammingRepository;
        $this->dailyProgrammingFormFactory = $dailyProgrammingFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyProgramming:default';
        $this->template->menuMonthsCssClass = 'daily-programming-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyProgrammingsByDayNumber = $this->dailyProgrammingRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyProgrammingForm(): DailyProgrammingForm
    {
        return $this->dailyProgrammingFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyProgramming = $this->dailyProgrammingRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyProgramming === null) {
            $this['dailyProgrammingForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyProgrammingForm']['form']['month']->setDefaultValue($month);
            $this['dailyProgrammingForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyProgrammingForm']['form']['id']->setDefaultValue($dailyProgramming->getId());
            $this['dailyProgrammingForm']['form']['programming_duration']->setDefaultValue($dailyProgramming->getProgrammingDuration());
            $this['dailyProgrammingForm']['form']['day_type']->setDefaultValue($dailyProgramming->getDayType());
            $this['dailyProgrammingForm']['form']['day_part']->setDefaultValue($dailyProgramming->getDayPart());
            $this['dailyProgrammingForm']['form']['note']->setDefaultValue($dailyProgramming->getNote());
            $this['dailyProgrammingForm']['form']['illness']->setDefaultValue($dailyProgramming->getIllness());
            $this['dailyProgrammingForm']['form']['day_number']->setDefaultValue($dailyProgramming->getDayNumber());
            $this['dailyProgrammingForm']['form']['month']->setDefaultValue($dailyProgramming->getMonth());
            $this['dailyProgrammingForm']['form']['year']->setDefaultValue($dailyProgramming->getYear());
            $this['dailyProgrammingForm']['form']['created']->setDefaultValue($dailyProgramming->getCreated()->format('Y-m-d'));
        }
    }
}