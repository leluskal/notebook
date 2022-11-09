<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\WeeklyToDo\WeeklyToDoForm;
use App\FrontModule\Components\Forms\WeeklyToDo\WeeklyToDoFormFactory;
use App\Model\WeeklyToDo\WeeklyToDoRepository;

class WeeklyToDoPresenter extends BasePresenter
{
    /**
     * @var WeeklyToDoRepository
     */
    private $weeklyToDoRepository;

    /**
     * @var WeeklyToDoFormFactory
     */
    private $weeklyToDoFormFactory;

    public function __construct(WeeklyToDoRepository $weeklyToDoRepository, WeeklyToDoFormFactory $weeklyToDoFormFactory)
    {
        $this->weeklyToDoRepository = $weeklyToDoRepository;
        $this->weeklyToDoFormFactory = $weeklyToDoFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function createComponentWeeklyToDoForm(): WeeklyToDoForm
    {
        return $this->weeklyToDoFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $weeklyToDo = $this->weeklyToDoRepository->getById($id);

        $this['weeklyToDoForm']['form']['id']->setDefaultValue($weeklyToDo->getId());
        $this['weeklyToDoForm']['form']['task']->setDefaultValue($weeklyToDo->getTask());
        $this['weeklyToDoForm']['form']['note']->setDefaultValue($weeklyToDo->getNote());
        $this['weeklyToDoForm']['form']['done']->setDefaultValue($weeklyToDo->getDone());
        $this['weeklyToDoForm']['form']['week_number']->setDefaultValue($weeklyToDo->getWeekNumber());
        $this['weeklyToDoForm']['form']['year']->setDefaultValue($weeklyToDo->getYear());
    }

    public function renderCreate(int $weekNumber, int $year)
    {
        $this['weeklyToDoForm']['form']['week_number']->setDefaultValue($weekNumber);
        $this['weeklyToDoForm']['form']['year']->setDefaultValue($year);
    }
}