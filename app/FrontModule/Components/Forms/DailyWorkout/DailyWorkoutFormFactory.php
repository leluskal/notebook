<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyWorkout;

use App\Model\DailyWorkout\DailyWorkoutRepository;
use App\Model\FitnessInstructor\FitnessInstructorRepository;

class DailyWorkoutFormFactory
{
    /**
     * @var FitnessInstructorRepository
     */
    private $fitnessInstructorRepository;

    /**
     * @var DailyWorkoutRepository
     */
    private $dailyWorkoutRepository;

    public function __construct(
        FitnessInstructorRepository $fitnessInstructorRepository,
        DailyWorkoutRepository $dailyWorkoutRepository
    )
    {
        $this->fitnessInstructorRepository = $fitnessInstructorRepository;
        $this->dailyWorkoutRepository = $dailyWorkoutRepository;
    }

    public function create(): DailyWorkoutForm
    {
        return new DailyWorkoutForm($this->fitnessInstructorRepository, $this->dailyWorkoutRepository);
    }
}