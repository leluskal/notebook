<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\DailyBodyCare\DailyBodyCareRepository;
use App\Model\DailyEating\DailyEatingRepository;
use App\Model\DailyMobile\DailyMobileRepository;
use App\Model\DailyNumberOfStep\DailyNumberOfStepRepository;
use App\Model\DailyProgramming\DailyProgrammingRepository;
use App\Model\DailySleeping\DailySleepingRepository;
use App\Model\DailyStretching\DailyStretchingRepository;
use App\Model\DailyWorkout\DailyWorkoutRepository;

class AvatarPresenter extends BasePresenter
{
    /**
     * @var DailyStretchingRepository
     */
    private $dailyStretchingRepository;

    /**
     * @var DailyEatingRepository
     */
    private $dailyEatingRepository;

    /**
     * @var DailyNumberOfStepRepository
     */
    private $dailyNumberOfStepRepository;

    /**
     * @var DailyProgrammingRepository
     */
    private $dailyProgrammingRepository;

    /**
     * @var DailyWorkoutRepository
     */
    private $dailyWorkoutRepository;

    /**
     * @var DailyMobileRepository
     */
    private $dailyMobileRepository;

    /**
     * @var DailySleepingRepository
     */
    private $dailySleepingRepository;

    /**
     * @var DailyBodyCareRepository
     */
    private $dailyBodyCareRepository;

    public function __construct(
        DailyStretchingRepository $dailyStretchingRepository,
        DailyEatingRepository $dailyEatingRepository,
        DailyNumberOfStepRepository $dailyNumberOfStepRepository,
        DailyProgrammingRepository $dailyProgrammingRepository,
        DailyWorkoutRepository $dailyWorkoutRepository,
        DailyMobileRepository $dailyMobileRepository,
        DailySleepingRepository $dailySleepingRepository,
        DailyBodyCareRepository $dailyBodyCareRepository
    )
    {
        $this->dailyStretchingRepository = $dailyStretchingRepository;
        $this->dailyEatingRepository = $dailyEatingRepository;
        $this->dailyNumberOfStepRepository = $dailyNumberOfStepRepository;
        $this->dailyProgrammingRepository = $dailyProgrammingRepository;
        $this->dailyWorkoutRepository = $dailyWorkoutRepository;
        $this->dailyMobileRepository = $dailyMobileRepository;
        $this->dailySleepingRepository = $dailySleepingRepository;
        $this->dailyBodyCareRepository = $dailyBodyCareRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutAvatar');
    }

    public function renderDefault(string $selectedDate = null)
    {

        if ($selectedDate === null) {
            $actualDate = new \DateTime();
        } else {
            $actualDate = \DateTime::createFromFormat('Y-m-d', $selectedDate); //ak nie je vybrany datum, tak aktualny
        }

        $this->template->actualDate = $actualDate;

        $previousDate = clone $actualDate;
        $previousDate->modify('-1 day');
        $this->template->previousDate = $previousDate;

        $nextDate = clone $actualDate;
        $nextDate->modify('+1 day');
        $this->template->nextDate = $nextDate;

        $this->template->dailyStretchings = $this->dailyStretchingRepository->findAllByCreated($actualDate->format('Y-m-d'));

        $this->template->dailyEatings = $this->dailyEatingRepository->findAllByCreated($actualDate->format('Y-m-d'));

        $this->template->dailyNumberOfSteps = $this->dailyNumberOfStepRepository->findAllByCreated($actualDate->format('Y-m-d'));

        $this->template->dailyProgrammings = $this->dailyProgrammingRepository->findAllByCreated($actualDate->format('Y-m-d'));

        $this->template->dailyWorkoutTime = $this->dailyWorkoutRepository->getTotalWorkoutTimeByCreated($actualDate->format('Y-m-d'));

        $this->template->dailyMobiles = $this->dailyMobileRepository->findAllByCreated($actualDate->format('Y-m-d'));
        $this->template->mobileSpentTime = $this->dailyMobileRepository->getTotalSpentTimeByCreated($actualDate->format('Y-m-d'));

        $this->template->percentageFaceCare = $this->dailyBodyCareRepository->getPercentageByCreated($actualDate->format('Y-m-d'));

        $this->template->dailySleepings = $this->dailySleepingRepository->findAllByCreated($actualDate->format('Y-m-d'));

    }


}