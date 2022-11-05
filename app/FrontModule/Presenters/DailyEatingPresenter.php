<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyEating\DailyEatingForm;
use App\FrontModule\Components\Forms\DailyEating\DailyEatingFormFactory;
use App\Model\DailyBodyWeight\DailyBodyWeightRepository;
use App\Model\DailyEating\DailyEatingRepository;

class DailyEatingPresenter extends BasePresenter
{
    /**
     * @var DailyEatingRepository
     */
    private $dailyEatingRepository;

    /**
     * @var DailyEatingFormFactory
     */
    private $dailyEatingFormFactory;

    /**
     * @var DailyBodyWeightRepository
     */
    private $dailyBodyWeightRepository;

    public function __construct(
        DailyEatingRepository $dailyEatingRepository,
        DailyEatingFormFactory $dailyEatingFormFactory,
        DailyBodyWeightRepository $dailyBodyWeightRepository
    )
    {
        $this->dailyEatingRepository = $dailyEatingRepository;
        $this->dailyEatingFormFactory = $dailyEatingFormFactory;
        $this->dailyBodyWeightRepository =$dailyBodyWeightRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyEating:default';
        $this->template->menuMonthsCssClass = 'daily-eating-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyEatingsByDayNumber = $this->dailyEatingRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );
        $this->template->bodyWeightsByDayNumber = $this->dailyBodyWeightRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyEatingForm(): DailyEatingForm
    {
        return $this->dailyEatingFormFactory->create();
    }

    public function renderEdit(int $dayNumber, int $month, int $year)
    {
        $dailyEating = $this->dailyEatingRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        $this->template->dailyEating = $dailyEating;

        $this['dailyEatingForm']['form']['id']->setDefaultValue($dailyEating->getId());
        $this['dailyEatingForm']['form']['calorie_number']->setDefaultValue($dailyEating->getCalorieNumber());
        $this['dailyEatingForm']['form']['day_type']->setDefaultValue($dailyEating->getDayType());
        $this['dailyEatingForm']['form']['note']->setDefaultValue($dailyEating->getNote());
        $this['dailyEatingForm']['form']['calorie_estimate']->setDefaultValue($dailyEating->getCalorieEstimate());
        $this['dailyEatingForm']['form']['outside_food']->setDefaultValue($dailyEating->getOutsideFood());
        $this['dailyEatingForm']['form']['day_number']->setDefaultValue($dailyEating->getDayNumber());
        $this['dailyEatingForm']['form']['month']->setDefaultValue($dailyEating->getMonth());
        $this['dailyEatingForm']['form']['year']->setDefaultValue($dailyEating->getYear());
        $this['dailyEatingForm']['form']['created']->setDefaultValue($dailyEating->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $dayNumber)
    {
        $this['dailyEatingForm']['form']['day_number']->setDefaultValue($dayNumber);
        $this['dailyEatingForm']['form']['month']->setDefaultValue((int) $this->month);
        $this['dailyEatingForm']['form']['year']->setDefaultValue((int) $this->year);
    }
}