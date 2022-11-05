<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyWorkout\DailyWorkoutForm;
use App\FrontModule\Components\Forms\DailyWorkout\DailyWorkoutFormFactory;
use App\Model\DailyNumberOfStep\DailyNumberOfStepRepository;
use App\Model\DailyWorkout\DailyWorkoutRepository;

class DailyWorkoutPresenter extends BasePresenter
{
    /**
     * @var DailyWorkoutRepository
     */
    private $dailyWorkoutRepository;

    /**
     * @var DailyWorkoutFormFactory
     */
    private $dailyWorkoutFormFactory;

    /**
     * @var DailyNumberOfStepRepository
     */
    private $dailyNumberOfStepRepository;

    public function __construct(
        DailyWorkoutRepository $dailyWorkoutRepository,
        DailyWorkoutFormFactory $dailyWorkoutFormFactory,
        DailyNumberOfStepRepository $dailyNumberOfStepRepository
    )
    {
        $this->dailyWorkoutRepository = $dailyWorkoutRepository;
        $this->dailyWorkoutFormFactory = $dailyWorkoutFormFactory;
        $this->dailyNumberOfStepRepository = $dailyNumberOfStepRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyWorkout:default';
        $this->template->menuMonthsCssClass = 'daily-workout-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyWorkoutsByDayNumber = $this->dailyWorkoutRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );
        $this->template->instructorsByDayNumber = $this->dailyWorkoutRepository->findAllInstructorsByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );
        $this->template->stepsByDayNumber = $this->dailyNumberOfStepRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyWorkoutForm(): DailyWorkoutForm
    {
        return $this->dailyWorkoutFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $dailyWorkout = $this->dailyWorkoutRepository->getById($id);

        $this->template->dailyWorkout = $dailyWorkout;

        $this['dailyWorkoutForm']['form']['id']->setDefaultValue($dailyWorkout->getId());
        $this['dailyWorkoutForm']['form']['fitness_instructor_id']->setDefaultValue($dailyWorkout->getFitnessInstructorId());
        $this['dailyWorkoutForm']['form']['workout_time']->setDefaultValue($dailyWorkout->getWorkoutTime());
        $this['dailyWorkoutForm']['form']['note']->setDefaultValue($dailyWorkout->getNote());
        $this['dailyWorkoutForm']['form']['illness']->setDefaultValue($dailyWorkout->getIllness());
        $this['dailyWorkoutForm']['form']['day_number']->setDefaultValue($dailyWorkout->getDayNumber());
        $this['dailyWorkoutForm']['form']['month']->setDefaultValue($dailyWorkout->getMonth());
        $this['dailyWorkoutForm']['form']['year']->setDefaultValue($dailyWorkout->getYear());
        $this['dailyWorkoutForm']['form']['created']->setDefaultValue($dailyWorkout->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $dayNumber)
    {
        $this['dailyWorkoutForm']['form']['day_number']->setDefaultValue($dayNumber);
        $this['dailyWorkoutForm']['form']['month']->setDefaultValue((int) $this->month);
        $this['dailyWorkoutForm']['form']['year']->setDefaultValue((int) $this->year);
    }
}