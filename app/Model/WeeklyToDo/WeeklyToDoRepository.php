<?php
declare(strict_types=1);

namespace App\Model\WeeklyToDo;

use App\Model\BaseRepository;

class WeeklyToDoRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'weekly_to_do';
    }

    public function getById(int $id): ?WeeklyToDo
    {
        $row = $this->getDbConnection()->query('SELECT * FROM weekly_to_do WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $weeklyToDo = new WeeklyToDo(
            (string)$row->task,
            (int)$row->done,
            (int)$row->week_number,
            (int)$row->year
        );
        $weeklyToDo->setId((int)$row->id);
        $weeklyToDo->setNote($row->note);

        return $weeklyToDo;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $weeklyToDos = [];

        foreach ($rows as $row) {
            $weeklyToDo = new WeeklyToDo(
                (string)$row->task,
                (int)$row->done,
                (int)$row->week_number,
                (int)$row->year
            );
            $weeklyToDo->setId((int)$row->id);
            $weeklyToDo->setNote($row->note);

            $weeklyToDos[] = $weeklyToDo;
        }

        return $weeklyToDos;
    }

    public function findAllByWeekNumberAndYear(int $weekNumber, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM weekly_to_do WHERE week_number = ? AND year = ?', $weekNumber, $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}