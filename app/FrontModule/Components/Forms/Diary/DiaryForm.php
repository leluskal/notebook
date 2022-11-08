<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Diary;

use App\Model\Diary\DiaryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DiaryForm extends Control
{
    /**
     * @var DiaryRepository
     */
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('heading', 'Heading')
             ->setRequired('The heading is required');

        $form->addTextArea('notes', 'Notes')
             ->setRequired('The notes are required');

        $form->addText('month', 'Month')
             ->setRequired('The month is required');

        $form->addHidden('year');

        $form->addText('created', 'Created')
             ->setRequired('The created is required')
             ->setHtmlType('date');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        $form->onError[] = [$this, 'formError'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->diaryRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is deleted', 'success');
            $this->getPresenter()->redirect('Diary:default', ['month' => $values->month]);
        }

        if ($values->id === '') {
            $this->diaryRepository->create([
               'heading' => $values->heading,
               'notes' => $values->notes,
               'month' => $values->month,
               'year' => $values->year,
               'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'heading' => $values->heading,
                'notes' => $values->notes,
                'month' => $values->month,
                'year' => $values->year,
                'created' => $values->created
            ];

            $this->diaryRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->getPresenter()->redirect('Diary:default', ['month' => $values->month]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/diaryForm.latte');
        $template->render();
    }
}