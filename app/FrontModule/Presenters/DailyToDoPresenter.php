<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DailyToDo\DailyToDoForm;
use App\FrontModule\Components\Forms\DailyToDo\DailyToDoFormFactory;
use App\Model\DailyToDo\DailyToDoRepository;

class DailyToDoPresenter extends BasePresenter
{
    /**
     * @var DailyToDoRepository
     */
    private $dailyToDoRepository;

    /**
     * @var DailyToDoFormFactory
     */
    private $dailyToDoFormFactory;

    public function __construct(DailyToDoRepository $dailyToDoRepository, DailyToDoFormFactory $dailyToDoFormFactory)
    {
        $this->dailyToDoRepository = $dailyToDoRepository;
        $this->dailyToDoFormFactory = $dailyToDoFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'DailyToDo:default';
        $this->template->menuMonthsCssClass = 'daily-to-do-menu';
    }

    public function renderDefault()
    {
        $this->template->dailyToDoByDayNumber = $this->dailyToDoRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentDailyToDoForm(): DailyToDoForm
    {
        return $this->dailyToDoFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $dailyToDo = $this->dailyToDoRepository->getById($id);

        $this['dailyToDoForm']['form']['id']->setDefaultValue($dailyToDo->getId());
        $this['dailyToDoForm']['form']['task']->setDefaultValue($dailyToDo->getTask());
        $this['dailyToDoForm']['form']['note']->setDefaultValue($dailyToDo->getNote());
        $this['dailyToDoForm']['form']['done']->setDefaultValue($dailyToDo->getDone());
        $this['dailyToDoForm']['form']['day_number']->setDefaultValue($dailyToDo->getDayNumber());
        $this['dailyToDoForm']['form']['month']->setDefaultValue($dailyToDo->getMonth());
        $this['dailyToDoForm']['form']['year']->setDefaultValue($dailyToDo->getYear());
        $this['dailyToDoForm']['form']['created']->setDefaultValue($dailyToDo->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $dayNumber)
    {
        $this['dailyToDoForm']['form']['day_number']->setDefaultValue($dayNumber);
        $this['dailyToDoForm']['form']['month']->setDefaultValue((int) $this->month);
        $this['dailyToDoForm']['form']['year']->setDefaultValue((int) $this->year);
    }
}