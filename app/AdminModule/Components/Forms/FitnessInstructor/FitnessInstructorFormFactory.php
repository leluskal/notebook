<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\FitnessInstructor;

use App\Model\FitnessInstructor\FitnessInstructorRepository;

class FitnessInstructorFormFactory
{
    /**
     * @var FitnessInstructorRepository
     */
    private $fitnessInstructorRepository;

    public function __construct(FitnessInstructorRepository $fitnessInstructorRepository)
    {
        $this->fitnessInstructorRepository = $fitnessInstructorRepository;
    }

    public function create(): FitnessInstructorForm
    {
        return new FitnessInstructorForm($this->fitnessInstructorRepository);
    }
}