<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\FitnessInstructor\FitnessInstructorForm;
use App\AdminModule\Components\Forms\FitnessInstructor\FitnessInstructorFormFactory;
use App\Model\FitnessInstructor\FitnessInstructorRepository;
use App\Presenters\BaseAuthorizedPresenter;

class FitnessInstructorPresenter extends BaseAuthorizedPresenter
{
    /**
     * @var FitnessInstructorRepository
     */
    private $fitnessInstructorRepository;

    /**
     * @var FitnessInstructorFormFactory
     */
    private $fitnessInstructorFormFactory;

    public function __construct(
        FitnessInstructorRepository $fitnessInstructorRepository,
        FitnessInstructorFormFactory $fitnessInstructorFormFactory
    )
    {
        $this->fitnessInstructorRepository = $fitnessInstructorRepository;
        $this->fitnessInstructorFormFactory = $fitnessInstructorFormFactory;
    }

    public function renderDefault()
    {
        $this->template->fitnessInstructors = $this->fitnessInstructorRepository->findAll();
    }

    public function createComponentFitnessInstructorForm(): FitnessInstructorForm
    {
        return $this->fitnessInstructorFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $fitnessInstructor = $this->fitnessInstructorRepository->getById($id);

        $this->template->fitnessInstructor = $fitnessInstructor;

        $this['fitnessInstructorForm']['form']['id']->setDefaultValue($fitnessInstructor->getId());
        $this['fitnessInstructorForm']['form']['name']->setDefaultValue($fitnessInstructor->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteFitnessInstructor(int $id)
    {
        $this->fitnessInstructorRepository->deleteById($id);

        $this->flashMessage('The fitness instructor is deleted', 'info');
        $this->redirect('FitnessInstructor:default');
    }
}