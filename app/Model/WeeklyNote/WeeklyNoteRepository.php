<?php
declare(strict_types=1);

namespace App\Model\WeeklyNote;

use App\Model\BaseRepository;

class WeeklyNoteRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'weekly_note';
    }

    public function getById(int $id): ?WeeklyNote
    {
        $row = $this->getDbConnection()->query('SELECT * FROM weekly_note WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $weeklyNote = new WeeklyNote(
            (string)$row->plan,
            (int)$row->week_number,
            (int)$row->year
        );
        $weeklyNote->setId((int)$row->id);
        $weeklyNote->setReality($row->reality);
        $weeklyNote->setRating($row->rating);

        return $weeklyNote;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $weeklyNotes = [];

        foreach ($rows as $row) {
            $weeklyNote = new WeeklyNote(
                (string)$row->plan,
                (int)$row->week_number,
                (int)$row->year
            );
            $weeklyNote->setId((int)$row->id);
            $weeklyNote->setReality($row->reality);
            $weeklyNote->setRating($row->rating);

            $weeklyNotes[] = $weeklyNote;
        }


        return $weeklyNotes;
    }

    public function findAllByWeekNumberAndYear(int $weekNumber, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM weekly_note WHERE week_number = ? AND year = ?', $weekNumber, $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}