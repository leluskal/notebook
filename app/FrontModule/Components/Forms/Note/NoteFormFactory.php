<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Note;

use App\Model\Note\NoteRepository;

class NoteFormFactory
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function create(): NoteForm
    {
        return new NoteForm($this->noteRepository);
    }
}