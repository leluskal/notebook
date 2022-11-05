<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyWorkout;

use App\Model\DailyWorkout\DailyWorkoutRepository;
use App\Model\FitnessInstructor\FitnessInstructorRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyWorkoutForm extends Control
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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('fitness_instructor_id', 'Fitness Instructor', $this->fitnessInstructorRepository->findAllForSelectBox())
             ->setPrompt('--Choose fitness instructor--')
             ->setRequired('The fitness instructor is required');

        $form->addInteger('workout_time', 'Workout Time');

        $form->addTextArea('note', 'Note');

        $form->addCheckbox('illness', 'Illness?');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addText('created', 'Created')
             ->setHtmlType('date')
             ->setRequired('The created is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
           $this->dailyWorkoutRepository->deleteById((int) $values->id);
           $this->getPresenter()->flashMessage('The record of workout is deleted', 'info');
           $this->getPresenter()->redirect('DailyWorkout:default');
        }

        if ($values->id === '') {
            $this->dailyWorkoutRepository->create([
                'fitness_instructor_id' => $values->fitness_instructor_id,
                'workout_time' => $values->workout_time !== '' ? $values->workout_time : null,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of workout is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'fitness_instructor_id' => $values->fitness_instructor_id,
                'workout_time' => $values->workout_time !== '' ? $values->workout_time : null,
                'note' => $values->note !== '' ? $values->note : null,
                'illness' => $values->illness,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->dailyWorkoutRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of workout is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyWorkout:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyWorkoutForm.latte');
        $template->render();
    }
}