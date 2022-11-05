<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyStretching\DailyStretchingForm;
use App\FrontModule\Components\Forms\DailyStretching\DailyStretchingFormFactory;
use App\Model\DailyStretching\DailyStretchingRepository;

class DailyStretchingPresenter extends BasePresenter
{
    /**
     * @var DailyStretchingRepository
     */
    private $dailyStretchingRepository;

    /**
     * @var DailyStretchingFormFactory
     */
    private $dailyStretchingFormFactory;

    public function __construct(
        DailyStretchingRepository $dailyStretchingRepository,
        DailyStretchingFormFactory $dailyStretchingFormFactory
    )
    {
        $this->dailyStretchingRepository = $dailyStretchingRepository;
        $this->dailyStretchingFormFactory = $dailyStretchingFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyStretching:default';
        $this->template->menuMonthsCssClass = 'daily-stretching-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyStretchingsByDayNumber = $this->dailyStretchingRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyStretchingForm(): DailyStretchingForm
    {
        return $this->dailyStretchingFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyStretching = $this->dailyStretchingRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyStretching === null) {
            $this['dailyStretchingForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyStretchingForm']['form']['month']->setDefaultValue($month);
            $this['dailyStretchingForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyStretchingForm']['form']['id']->setDefaultValue($dailyStretching->getId());
            $this['dailyStretchingForm']['form']['stretch_time']->setDefaultValue($dailyStretching->getStretchTime());
            $this['dailyStretchingForm']['form']['day_type']->setDefaultValue($dailyStretching->getDayType());
            $this['dailyStretchingForm']['form']['day_part']->setDefaultValue($dailyStretching->getDayPart());
            $this['dailyStretchingForm']['form']['note']->setDefaultValue($dailyStretching->getNote());
            $this['dailyStretchingForm']['form']['illness']->setDefaultValue($dailyStretching->getIllness());
            $this['dailyStretchingForm']['form']['day_number']->setDefaultValue($dailyStretching->getDayNumber());
            $this['dailyStretchingForm']['form']['month']->setDefaultValue($dailyStretching->getMonth());
            $this['dailyStretchingForm']['form']['year']->setDefaultValue($dailyStretching->getYear());
            $this['dailyStretchingForm']['form']['created']->setDefaultValue($dailyStretching->getCreated()->format('Y-m-d'));
        }
    }
}