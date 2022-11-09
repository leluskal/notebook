<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DayType;

use App\Model\DayType\DayTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DayTypeForm extends Control
{
    /**
     * @var DayTypeRepository
     */
    private $dayTypeRepository;

    public function __construct(DayTypeRepository $dayTypeRepository)
    {
        $this->dayTypeRepository = $dayTypeRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Day Type')
             ->setRequired('The name is required');

        $form->addCheckbox('work_day', 'Work Day?');

        $form->addText('created', 'Created')
             ->setHtmlType('date')
             ->setRequired('The date is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id'], $form['created']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->dayTypeRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The day type is deleted', 'info');
            $this->getPresenter()->redirect('WeekPlan:detailDay', ['day' => $values->created]);
        }

        if ($values->id === '') {
            $this->dayTypeRepository->create([
                'name' => $values->name,
                'work_day' => $values->work_day,
                'created' => $values->created,
                'year' => $values->year
            ]);
            $this->getPresenter()->flashMessage('The new day type is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
                'work_day' => $values->work_day,
                'created' => $values->created,
                'year' => $values->year
            ];

            $this->dayTypeRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The day type is updated', 'info');
        }

        $this->getPresenter()->redirect('WeekPlan:detailDay', ['day' => $values->created]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dayTypeForm.latte');
        $template->render();
    }
}