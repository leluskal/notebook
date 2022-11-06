<?php
declare(strict_types=1);

namespace App\Model\DailyToDo;

use App\Model\BaseRepository;

class DailyToDoRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_to_do';
    }

    public function getById(int $id): ?DailyToDo
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_to_do WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $dailyToDo = new DailyToDo(
            (string)$row->task,
            (int)$row->done,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyToDo->setId((int)$row->id);
        $dailyToDo->setNote($row->note);

        return $dailyToDo;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_to_do WHERE month = ? AND year = ?',
            $month,
            $year)
            ->fetchAll();

        $dailyToDoByDayNumber = [];

        foreach ($rows as $row) {
            $dailyToDoByDayNumber[$row->day_number][] = [
                'id' => $row->id,
                'task' => $row->task,
                'note' => $row->note,
                'done' => $row->done,
            ];
        }

        return $dailyToDoByDayNumber;
    }
}