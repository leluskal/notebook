<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Note;

use App\Model\Note\NoteRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class NoteForm extends Control
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addTextArea('text', 'Text')
             ->setRequired('The notes are required');

        $form->addCheckbox('quote', 'Quote');

        $form->addText('created', 'Created')
             ->setHtmlType('date')
             ->setRequired('The created is required');

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
            $this->noteRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The note is deleted', 'info');
            $this->getPresenter()->redirect('WeekPlan:detailDay', ['day' => $values->created]);
        }

        if ($values->id === '') {
            $this->noteRepository->create([
                'text' => $values->text,
                'quote' => $values->quote,
                'created' => $values->created,
                'year' => $values->year
            ]);
            $this->getPresenter()->flashMessage('The new notes are updated', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'text' => $values->text,
                'quote' => $values->quote,
                'created' => $values->created,
                'year' => $values->year
            ];

            $this->noteRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The notes are updated', 'info');
        }
        $this->getPresenter()->redirect('WeekPlan:detailDay', ['day' => $values->created]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/noteForm.latte');
        $template->render();
    }
}