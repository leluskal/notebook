<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Task\TaskForm;
use App\FrontModule\Components\Forms\Task\TaskFormFactory;
use App\Model\DayType\DayTypeRepository;
use App\Model\Note\NoteRepository;
use App\Model\Task\TaskRepository;
use App\Model\Task\TaskService;
use App\Model\Utils;
use App\Model\WeeklyNote\WeeklyNoteRepository;
use App\Model\WeeklyToDo\WeeklyToDoRepository;

class WeekPlanPresenter extends BasePresenter
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * @var TaskFormFactory
     */
    private $taskFormFactory;

    /**
     * @var DayTypeRepository
     */
    private $dayTypeRepository;

    /**
     * @var WeeklyToDoRepository
     */
    private $weeklyToDoRepository;

    /**
     * @var WeeklyNoteRepository
     */
    private $weeklyNoteRepository;

    public function __construct(
        TaskRepository $taskRepository,
        NoteRepository $noteRepository,
        TaskService $taskService,
        TaskFormFactory $taskFormFactory,
        DayTypeRepository $dayTypeRepository,
        WeeklyToDoRepository $weeklyToDoRepository,
        WeeklyNoteRepository $weeklyNoteRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->noteRepository = $noteRepository;
        $this->taskService = $taskService;
        $this->taskFormFactory = $taskFormFactory;
        $this->dayTypeRepository = $dayTypeRepository;
        $this->weeklyToDoRepository = $weeklyToDoRepository;
        $this->weeklyNoteRepository = $weeklyNoteRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function renderDefault()
    {
        $this->template->allWeeks = Utils::getAllWeeks((int) $this->year);
        $this->template->year = $this->year;
    }

    public function renderDetailWeek(int $weekNumber, $day = null)
    {
        $this->template->days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];

        $this->template->weekRangeString = Utils::getWeekRangeByWeekNumberAndYear($weekNumber, (int) $this->year);
        $this->template->weekNumber = $weekNumber;
        $this->template->year = $this->year;
        $this->template->weekRangeDateTimes = Utils::getWeekRangeDateTimes($weekNumber, (int) $this->year);

        $this->template->weeklyToDos = $this->weeklyToDoRepository->findAllByWeekNumberAndYear($weekNumber, (int) $this->year);
        $this->template->weeklyNotes = $this->weeklyNoteRepository->findAllByWeekNumberAndYear($weekNumber, (int) $this->year);
    }

    public function renderDetailDay(string $day)
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', $day);
        $this->template->day = $day;
        $this->template->dateTime = $dateTime;
        $this->template->year = $this->year;

        $this->template->dayTypes = $this->dayTypeRepository->findAllByCreated($dateTime->format('Y-m-d'));
        $this->template->notes = $this->noteRepository->findAllByCreated($dateTime->format('Y-m-d'));

        $tasks = $this->taskRepository->findAllByCreated($dateTime->format('Y-m-d'));
        $tasks = $this->taskService->mapEntityToArray($tasks);
        $this->template->tasks = $tasks;

    }

    public function createComponentTaskForm(): TaskForm
    {
        $form = $this->taskFormFactory->create();

        $form->onFinish[] = function (TaskForm $taskForm) use ($form) {
            $this->redirect('WeekPlan:detailDay', ['day' => $form->getDay()]);
        };

        return $form;
    }

    public function renderCreate(int $year)
    {
        $this['taskForm']['form']['year']->setDefaultValue($year);
    }
}