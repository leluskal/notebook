<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyBodyWeight\DailyBodyWeightForm;
use App\FrontModule\Components\Forms\DailyBodyWeight\DailyBodyWeightFormFactory;
use App\Model\DailyBodyWeight\DailyBodyWeightRepository;

class DailyBodyWeightPresenter extends BasePresenter
{
    /**
     * @var DailyBodyWeightRepository
     */
    private $dailyBodyWeightRepository;

    /**
     * @var DailyBodyWeightFormFactory
     */
    private $dailyBodyWeightFormFactory;

    public function __construct(
        DailyBodyWeightRepository $dailyBodyWeightRepository,
        DailyBodyWeightFormFactory $dailyBodyWeightFormFactory
    )
    {
        $this->dailyBodyWeightRepository = $dailyBodyWeightRepository;
        $this->dailyBodyWeightFormFactory = $dailyBodyWeightFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyEating:default';
        $this->template->menuMonthsCssClass = 'daily-eating-menu';
    }

    public function createComponentDailyBodyWeightForm(): DailyBodyWeightForm
    {
        return $this->dailyBodyWeightFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyBodyWeight = $this->dailyBodyWeightRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyBodyWeight === null) {
            $this['dailyBodyWeightForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyBodyWeightForm']['form']['month']->setDefaultValue($month);
            $this['dailyBodyWeightForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyBodyWeightForm']['form']['id']->setDefaultValue($dailyBodyWeight->getId());
            $this['dailyBodyWeightForm']['form']['number']->setDefaultValue($dailyBodyWeight->getNumber());
            $this['dailyBodyWeightForm']['form']['day_number']->setDefaultValue($dailyBodyWeight->getDayNumber());
            $this['dailyBodyWeightForm']['form']['month']->setDefaultValue($dailyBodyWeight->getMonth());
            $this['dailyBodyWeightForm']['form']['year']->setDefaultValue($dailyBodyWeight->getYear());
            $this['dailyBodyWeightForm']['form']['created']->setDefaultValue($dailyBodyWeight->getCreated()->format('Y-m-d'));
        }
    }
}