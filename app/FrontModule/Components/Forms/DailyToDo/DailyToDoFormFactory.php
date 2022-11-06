<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyToDo;

use App\Model\DailyToDo\DailyToDoRepository;

class DailyToDoFormFactory
{
    /**
     * @var DailyToDoRepository
     */
    private $dailyToDoRepository;

    public function __construct(DailyToDoRepository $dailyToDoRepository)
    {
        $this->dailyToDoRepository = $dailyToDoRepository;
    }

    public function create(): DailyToDoForm
    {
        return new DailyToDoForm($this->dailyToDoRepository);
    }
}