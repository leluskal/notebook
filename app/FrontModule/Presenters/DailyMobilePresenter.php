<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyMobile\DailyMobileForm;
use App\FrontModule\Components\Forms\DailyMobile\DailyMobileFormFactory;
use App\Model\DailyMobile\DailyMobileRepository;

class DailyMobilePresenter extends BasePresenter
{
    /**
     * @var DailyMobileRepository
     */
    private $dailyMobileRepository;

    /**
     * @var DailyMobileFormFactory
     */
    private $dailyMobileFormFactory;

    public function __construct(
        DailyMobileRepository $dailyMobileRepository,
        DailyMobileFormFactory $dailyMobileFormFactory
    )
    {
        $this->dailyMobileRepository = $dailyMobileRepository;
        $this->dailyMobileFormFactory = $dailyMobileFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyMobile:default';
        $this->template->menuMonthsCssClass = 'daily-mobile-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyMobilesByDayNumber = $this->dailyMobileRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyMobileForm(): DailyMobileForm
    {
        return $this->dailyMobileFormFactory->create();
    }

    public function renderCreate(int $dayNumber, int $month, int $year)
    {
        $dailyMobile = $this->dailyMobileRepository->getByDayNumberAndMonthAndYear($dayNumber, $month, $year);

        if ($dailyMobile === null) {
            $this['dailyMobileForm']['form']['day_number']->setDefaultValue($dayNumber);
            $this['dailyMobileForm']['form']['month']->setDefaultValue($month);
            $this['dailyMobileForm']['form']['year']->setDefaultValue($year);
        } else {
            $this['dailyMobileForm']['form']['id']->setDefaultValue($dailyMobile->getId());
            $this['dailyMobileForm']['form']['day_type']->setDefaultValue($dailyMobile->getDayType());
            $this['dailyMobileForm']['form']['screen_usage_time']->setDefaultValue($dailyMobile->getScreenUsageTime());
            $this['dailyMobileForm']['form']['number_of_screen_unlocks']->setDefaultValue($dailyMobile->getNumberOfScreenUnlocks());
            $this['dailyMobileForm']['form']['non_interactive_mode_time']->setDefaultValue($dailyMobile->getNonInteractiveModeTime());
            $this['dailyMobileForm']['form']['reading_time']->setDefaultValue($dailyMobile->getReadingTime());
            $this['dailyMobileForm']['form']['playing_time']->setDefaultValue($dailyMobile->getPlayingTime());
            $this['dailyMobileForm']['form']['insta_time']->setDefaultValue($dailyMobile->getInstaTime());
            $this['dailyMobileForm']['form']['day_number']->setDefaultValue($dailyMobile->getDayNumber());
            $this['dailyMobileForm']['form']['month']->setDefaultValue($dailyMobile->getMonth());
            $this['dailyMobileForm']['form']['year']->setDefaultValue($dailyMobile->getYear());
            $this['dailyMobileForm']['form']['note']->setDefaultValue($dailyMobile->getNote());
            $this['dailyMobileForm']['form']['created']->setDefaultValue($dailyMobile->getCreated()->format('Y-m-d'));
        }
    }
}