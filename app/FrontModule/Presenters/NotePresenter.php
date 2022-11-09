<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Note\NoteForm;
use App\FrontModule\Components\Forms\Note\NoteFormFactory;
use App\FrontModule\Presenters\BasePresenter;
use App\Model\Note\NoteRepository;

class NotePresenter extends BasePresenter
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * @var NoteFormFactory
     */
    private $noteFormFactory;

    public function __construct(NoteRepository $noteRepository, NoteFormFactory $noteFormFactory)
    {
        $this->noteRepository = $noteRepository;
        $this->noteFormFactory = $noteFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function createComponentNoteForm(): NoteForm
    {
        return $this->noteFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $note = $this->noteRepository->getById($id);

        $this->template->note = $note;

        $this['noteForm']['form']['id']->setDefaultValue($note->getId());
        $this['noteForm']['form']['text']->setDefaultValue($note->getText());
        $this['noteForm']['form']['quote']->setDefaultValue($note->getQuote());
        $this['noteForm']['form']['created']->setDefaultValue($note->getCreated()->format('Y-m-d'));
        $this['noteForm']['form']['year']->setDefaultValue($note->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['noteForm']['form']['year']->setDefaultValue($year);
    }
}