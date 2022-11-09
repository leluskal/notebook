<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\WeeklyNote\WeeklyNoteForm;
use App\FrontModule\Components\Forms\WeeklyNote\WeeklyNoteFormFactory;
use App\Model\WeeklyNote\WeeklyNoteRepository;

class WeeklyNotePresenter extends BasePresenter
{
    /**
     * @var WeeklyNoteRepository
     */
    private $weeklyNoteRepository;

    /**
     * @var WeeklyNoteFormFactory
     */
    private $weeklyNoteFormFactory;

    public function __construct(WeeklyNoteRepository $weeklyNoteRepository, WeeklyNoteFormFactory $weeklyNoteFormFactory)
    {
        $this->weeklyNoteRepository = $weeklyNoteRepository;
        $this->weeklyNoteFormFactory = $weeklyNoteFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function createComponentWeeklyNoteForm(): WeeklyNoteForm
    {
        return $this->weeklyNoteFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $weeklyNote = $this->weeklyNoteRepository->getById($id);

        $this['weeklyNoteForm']['form']['id']->setDefaultValue($weeklyNote->getId());
        $this['weeklyNoteForm']['form']['plan']->setDefaultValue($weeklyNote->getPlan());
        $this['weeklyNoteForm']['form']['reality']->setDefaultValue($weeklyNote->getReality());
        $this['weeklyNoteForm']['form']['rating']->setDefaultValue($weeklyNote->getRating());
        $this['weeklyNoteForm']['form']['week_number']->setDefaultValue($weeklyNote->getWeekNumber());
        $this['weeklyNoteForm']['form']['year']->setDefaultValue($weeklyNote->getYear());
    }

    public function renderCreate(int $weekNumber, int $year)
    {
        $this['weeklyNoteForm']['form']['week_number']->setDefaultValue($weekNumber);
        $this['weeklyNoteForm']['form']['year']->setDefaultValue($year);
    }
}