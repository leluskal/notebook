<?php
declare(strict_types=1);

namespace App\Model\DailySleeping;

use App\Model\BaseRepository;

class DailySleepingRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_sleeping';
    }

    public function getById(int $id): ?DailySleeping
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_sleeping WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailySleeping = new DailySleeping(
            $row->time_go_to_bed,
            $row->time_get_up,
            (string)$row->day_type,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailySleeping->setId((int)$row->id);
        $dailySleeping->setNote($row->note);

        return $dailySleeping;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailySleeping
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_sleeping WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailySleeping = new DailySleeping(
            $row->time_go_to_bed,
            $row->time_get_up,
            (string)$row->day_type,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailySleeping->setId((int)$row->id);
        $dailySleeping->setNote($row->note);

        return $dailySleeping;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_sleeping WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailySleepingsByDayNumber = [];

        foreach ($rows as $row) {
            $dailySleepingsByDayNumber[$row->day_number] = [
                'time_go_to_bed' => $row->time_go_to_bed,
                'time_get_up' => $row->time_get_up,
                'day_type' => $row->day_type,
                'note' => $row->note,
                'illness' => $row->illness,
            ];
        }

        return $dailySleepingsByDayNumber;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_sleeping WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailySleepings = [];

        foreach ($rows as $row) {
            $dailySleeping = new DailySleeping(
                $row->time_go_to_bed,
                $row->time_get_up,
                (string)$row->day_type,
                (int)$row->illness,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailySleeping->setId((int)$row->id);
            $dailySleeping->setNote($row->note);

            $dailySleepings[] = $dailySleeping;
        }

        return $dailySleepings;
    }
}