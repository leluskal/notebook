<?php
declare(strict_types=1);

namespace App\Model\TaskCategory;

use App\Model\BaseRepository;

class TaskCategoryRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'task_category';
    }

    public function getById(int $id): ?TaskCategory
    {
        $row = $this->getDbConnection()->query('SELECT * FROM task_category WHERE id = ?', $id)->fetch();

        if ($row === null) {
          return null;
        }

        $taskCategory = new TaskCategory(
            (string)$row->name
        );
        $taskCategory->setId((int)$row->id);

        return $taskCategory;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $taskCategories = [];

        foreach ($rows as $row) {
            $taskCategory = new TaskCategory(
                (string)$row->name
            );
            $taskCategory->setId((int)$row->id);

            $taskCategories[] = $taskCategory;
        }

        return $taskCategories;
    }

    /**
     * @return TaskCategory[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM task_category')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $taskCategories = $this->findAll();

        $returnArray = [];

        foreach ($taskCategories as $taskCategory) {
            $returnArray[$taskCategory->getId()] = $taskCategory->getName();
        }

        return $returnArray;
    }
}