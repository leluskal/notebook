<?php
declare(strict_types=1);

namespace App\Model\Diary;

use App\Model\BaseRepository;

class DiaryRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'diary';
    }

    public function getById(int $id): ?Diary
    {
        $row = $this->getDbConnection()->query('SELECT * FROM diary WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $diary = new Diary(
            (string)$row->heading,
            (string)$row->notes,
            (string)$row->month,
            (int)$row->year,
            $row->created
        );
        $diary->setId((int)$row->id);

        return $diary;
    }

    public function findAllByMonthAndYear(string $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM diary WHERE month = ? AND year = ? ORDER BY id DESC', $month, $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllGroupedByMonth(string $month, int $year): array
    {
        $rows = $this->findAllByMonthAndYear($month, $year);

        $recordsGroupedByMonth = [];

        foreach ($rows as $row) {
            $month = $row->getMonth();
            $recordsGroupedByMonth[$month][] = $row;
        }

        return $recordsGroupedByMonth;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $diaries = [];

        foreach ($rows as $row) {
            $diary = new Diary(
                (string)$row->heading,
                (string)$row->notes,
                (string)$row->month,
                (int)$row->year,
                $row->created
            );
            $diary->setId((int)$row->id);

            $diaries[] = $diary;
        }

        return $diaries;
    }
}