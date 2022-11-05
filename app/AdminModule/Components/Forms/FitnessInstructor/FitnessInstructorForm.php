<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\FitnessInstructor;

use App\Model\FitnessInstructor\FitnessInstructorRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class FitnessInstructorForm extends Control
{
    /**
     * @var FitnessInstructorRepository
     */
    private $fitnessInstructorRepository;

    public function __construct(FitnessInstructorRepository $fitnessInstructorRepository)
    {
        $this->fitnessInstructorRepository = $fitnessInstructorRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Fitness Instructor')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->fitnessInstructorRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new fitness instructor is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->fitnessInstructorRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The fitness instructor is saved', 'info');
        }

        $this->getPresenter()->redirect('FitnessInstructor:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/fitnessInstructorForm.latte');
        $template->render();
    }
}