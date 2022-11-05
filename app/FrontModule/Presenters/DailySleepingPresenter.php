<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailySleeping\DailySleepingForm;
use App\FrontModule\Components\Forms\DailySleeping\DailySleepingFormFactory;
use App\Model\DailySleeping\DailySleepingRepository;

class DailySleepingPresenter extends BasePresenter
{
    /**
     * @var DailySleepingRepository
     */
    private $dailySleepingRepository;

    /**
     * @var DailySleepingFormFactory
     */
    private $dailySleepingFormFactory;

    public function __construct(
        DailySleepingRepository $dailySleepingRepository,
        DailySleepingFormFactory $dailySleepingFormFactory
    )
    {
        $this->dailySleepingRepository = $dailySleepingRepository;
        $this->dailySleepingFormFactory = $dailySleepingFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailySleeping:default';
        $this->template->menuMonthsCssClass = 'daily-sleeping-menu';
    }

    public function renderDefault()
    {
        $this->template->dailySleepingsByDayNumber = $this->dailySleepingRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailySleepingForm(): DailySleepingForm
    {
        return $this->dailySleepingFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailySleeping = $this->dailySleepingRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailySleeping === null) {
            $this['dailySleepingForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailySleepingForm']['form']['month']->setDefaultValue($month);
            $this['dailySleepingForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailySleepingForm']['form']['id']->setDefaultValue($dailySleeping->getId());
            $this['dailySleepingForm']['form']['time_go_to_bed']->setDefaultValue($dailySleeping->getTimeGoToBed()->format('Y-m-d\TH:i'));
            $this['dailySleepingForm']['form']['time_get_up']->setDefaultValue($dailySleeping->getTimeGetUp()->format('Y-m-d\TH:i'));
            $this['dailySleepingForm']['form']['day_type']->setDefaultValue($dailySleeping->getDayType());
            $this['dailySleepingForm']['form']['note']->setDefaultValue($dailySleeping->getNote());
            $this['dailySleepingForm']['form']['illness']->setDefaultValue($dailySleeping->getIllness());
            $this['dailySleepingForm']['form']['day_number']->setDefaultValue($dailySleeping->getDayNumber());
            $this['dailySleepingForm']['form']['month']->setDefaultValue($dailySleeping->getMonth());
            $this['dailySleepingForm']['form']['year']->setDefaultValue($dailySleeping->getYear());
            $this['dailySleepingForm']['form']['created']->setDefaultValue($dailySleeping->getCreated()->format('Y-m-d'));
        }
    }
}