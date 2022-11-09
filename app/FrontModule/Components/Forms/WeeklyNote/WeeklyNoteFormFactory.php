<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\WeeklyNote;

use App\Model\WeeklyNote\WeeklyNoteRepository;

class WeeklyNoteFormFactory
{
    /**
     * @var WeeklyNoteRepository
     */
    private $weeklyNoteRepository;

    public function __construct(WeeklyNoteRepository $weeklyNoteRepository)
    {
        $this->weeklyNoteRepository = $weeklyNoteRepository;
    }

    public function create(): WeeklyNoteForm
    {
        return new WeeklyNoteForm($this->weeklyNoteRepository);
    }
}