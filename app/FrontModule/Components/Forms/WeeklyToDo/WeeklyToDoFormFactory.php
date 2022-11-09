<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\WeeklyToDo;

use App\Model\WeeklyToDo\WeeklyToDoRepository;

class WeeklyToDoFormFactory
{
    /**
     * @var WeeklyToDoRepository
     */
    private $weeklyToDoRepository;

    public function __construct(WeeklyToDoRepository $weeklyToDoRepository)
    {
        $this->weeklyToDoRepository = $weeklyToDoRepository;
    }

    public function create(): WeeklyToDoForm
    {
        return new WeeklyToDoForm($this->weeklyToDoRepository);
    }
}