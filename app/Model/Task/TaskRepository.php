<?php
declare(strict_types=1);

namespace App\Model\Task;

use App\Model\BaseRepository;

class TaskRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'task';
    }

    public function getById(int $id): ?Task
    {
        $row =$this->getDbConnection()->query('SELECT * FROM task WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $task = new Task(
            (int)$row->task_category_id,
            (string)$row->name,
            (int)$row->done,
            $row->created,
            (int)$row->year
        );
        $task->setId((int)$row->id);
        $task->setNote($row->note);
        $task->setLink($row->link);

        return $task;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $tasks = [];

        foreach ($rows as $row) {
            $task = new Task(
                (int)$row->task_category_id,
                (string)$row->name,
                (int)$row->done,
                $row->created,
                (int)$row->year
            );
            $task->setId((int)$row->id);
            $task->setNote($row->note);
            $task->setLink($row->link);

            $tasks[] = $task;
        }

        return $tasks;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM task WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllByYear(int $year): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM task WHERE year = ?', $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllByTaskCategoryIdAndYear(int $taskCategoryId, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM task WHERE task_category_id = ? AND year = ?', $taskCategoryId, $year)
            ->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}