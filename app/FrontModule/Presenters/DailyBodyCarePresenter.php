<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyBodyCare\DailyBodyCareForm;
use App\FrontModule\Components\Forms\DailyBodyCare\DailyBodyCareFormFactory;
use App\Model\DailyBodyCare\DailyBodyCareRepository;

class DailyBodyCarePresenter extends BasePresenter
{
    /**
     * @var DailyBodyCareRepository
     */
    private $dailyBodyCareRepository;

    /**
     * @var DailyBodyCareFormFactory
     */
    private $dailyBodyCareFormFactory;

    public function __construct(
        DailyBodyCareRepository $dailyBodyCareRepository,
        DailyBodyCareFormFactory $dailyBodyCareFormFactory
    )
    {
        $this->dailyBodyCareRepository = $dailyBodyCareRepository;
        $this->dailyBodyCareFormFactory = $dailyBodyCareFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyBodyCare:default';
        $this->template->menuMonthsCssClass = 'daily-body-care-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyBodyCaresByDayNumber = $this->dailyBodyCareRepository->findAllByDayNumberAndMonth(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyBodyCareForm(): DailyBodyCareForm
    {
        return $this->dailyBodyCareFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyBodyCare = $this->dailyBodyCareRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyBodyCare === null) {
            $this['dailyBodyCareForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyBodyCareForm']['form']['month']->setDefaultValue($month);
            $this['dailyBodyCareForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyBodyCareForm']['form']['id']->setDefaultValue($dailyBodyCare->getId());
            $this['dailyBodyCareForm']['form']['face_morning']->setDefaultValue($dailyBodyCare->getFaceMorning());
            $this['dailyBodyCareForm']['form']['face_evening']->setDefaultValue($dailyBodyCare->getFaceEvening());
            $this['dailyBodyCareForm']['form']['teeth_morning']->setDefaultValue($dailyBodyCare->getTeethMorning());
            $this['dailyBodyCareForm']['form']['teeth_evening']->setDefaultValue($dailyBodyCare->getTeethEvening());
            $this['dailyBodyCareForm']['form']['dental_hygiene']->setDefaultValue($dailyBodyCare->getDentalHygiene());
            $this['dailyBodyCareForm']['form']['body_care']->setDefaultValue($dailyBodyCare->getBodyCare());
            $this['dailyBodyCareForm']['form']['day_number']->setDefaultValue($dailyBodyCare->getDayNumber());
            $this['dailyBodyCareForm']['form']['month']->setDefaultValue($dailyBodyCare->getMonth());
            $this['dailyBodyCareForm']['form']['year']->setDefaultValue($dailyBodyCare->getYear());
            $this['dailyBodyCareForm']['form']['created']->setDefaultValue($dailyBodyCare->getCreated()->format('Y-m-d'));
        }
    }
}