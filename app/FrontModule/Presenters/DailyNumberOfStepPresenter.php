<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyNumberOfStep\DailyNumberOfStepForm;
use App\FrontModule\Components\Forms\DailyNumberOfStep\DailyNumberOfStepFormFactory;
use App\Model\DailyNumberOfStep\DailyNumberOfStepRepository;

class DailyNumberOfStepPresenter extends BasePresenter
{
    /**
     * @var DailyNumberOfStepRepository
     */
    private $dailyNumberOfStepRepository;

    /**
     * @var DailyNumberOfStepFormFactory
     */
    private $dailyNumberOfStepFormFactory;

    public function __construct(
        DailyNumberOfStepRepository $dailyNumberOfStepRepository,
        DailyNumberOfStepFormFactory $dailyNumberOfStepFormFactory
    )
    {
        $this->dailyNumberOfStepRepository = $dailyNumberOfStepRepository;
        $this->dailyNumberOfStepFormFactory = $dailyNumberOfStepFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyWorkout:default'; //menu s mesiacmi, odkaz
        $this->template->menuMonthsCssClass = 'daily-workout-menu';
    }

    public function createComponentDailyNumberOfStepForm(): DailyNumberOfStepForm
    {
        return $this->dailyNumberOfStepFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyNumberOfStep = $this->dailyNumberOfStepRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyNumberOfStep === null) {
            $this['dailyNumberOfStepForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyNumberOfStepForm']['form']['month']->setDefaultValue($month);
            $this['dailyNumberOfStepForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyNumberOfStepForm']['form']['id']->setDefaultValue($dailyNumberOfStep->getId());
            $this['dailyNumberOfStepForm']['form']['number']->setDefaultValue($dailyNumberOfStep->getNumber());
            $this['dailyNumberOfStepForm']['form']['day_number']->setDefaultValue($dailyNumberOfStep->getDayNumber());
            $this['dailyNumberOfStepForm']['form']['month']->setDefaultValue($dailyNumberOfStep->getMonth());
            $this['dailyNumberOfStepForm']['form']['year']->setDefaultValue($dailyNumberOfStep->getYear());
            $this['dailyNumberOfStepForm']['form']['created']->setDefaultValue($dailyNumberOfStep->getCreated()->format('Y-m-d'));
        }
    }


}