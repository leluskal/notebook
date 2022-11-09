<?php

namespace App\FrontModule\Components\Forms\ApartmentList;

use App\Model\ApartmentList\ApartmentListRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class ApartmentListForm extends Control
{
    /**
     * @var ApartmentListRepository
     */
    private $apartmentListRepository;

    public function __construct(ApartmentListRepository $apartmentListRepository)
    {
        $this->apartmentListRepository = $apartmentListRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('task', 'Task')
            ->setRequired('The name is required');

        $form->addCheckbox('done', 'Done');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
            ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->apartmentListRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The task is deleted', 'info');
            $this->getPresenter()->redirect('ApartmentList:default');
        }

        if ($values->id === '') {
            $this->apartmentListRepository->create([
                'task' => $values->task,
                'done' => $values->done
            ]);
            $this->getPresenter()->flashMessage('The new task is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'task' => $values->task,
                'done' => $values->done
            ];

            $this->apartmentListRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The task is updated', 'info');
        }

        $this->getPresenter()->redirect('ApartmentList:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/apartmentListForm.latte');
        $template->render();
    }
}