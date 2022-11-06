<?php
declare(strict_types=1);

namespace App\Model\DailyMobile;

use App\Model\BaseRepository;

class DailyMobileRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_mobile';
    }

    public function getById(int $id): ?DailyMobile
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_mobile WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailyMobile = new DailyMobile(
            (int)$row->screen_usage_time,
            (int)$row->number_of_screen_unlocks,
            (string)$row->day_type,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyMobile->setId((int)$row->id);
        $dailyMobile->setNonInteractiveModeTime($row->non_interactive_mode_time);
        $dailyMobile->setReadingTime($row->reading_time);
        $dailyMobile->setPlayingTime($row->playing_time);
        $dailyMobile->setInstaTime($row->insta_time);
        $dailyMobile->setNote($row->note);

        return $dailyMobile;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyMobile
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_mobile WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyMobile = new DailyMobile(
            (int)$row->screen_usage_time,
            (int)$row->number_of_screen_unlocks,
            (string)$row->day_type,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyMobile->setId((int)$row->id);
        $dailyMobile->setNonInteractiveModeTime($row->non_interactive_mode_time);
        $dailyMobile->setReadingTime($row->reading_time);
        $dailyMobile->setPlayingTime($row->playing_time);
        $dailyMobile->setInstaTime($row->insta_time);
        $dailyMobile->setNote($row->note);

        return $dailyMobile;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_mobile WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailyMobilesByDayNumber = [];

        foreach ($rows as $row) {
            $dailyMobilesByDayNumber[$row->day_number] = [
                'screen_usage_time' => $row->screen_usage_time,
                'number_of_screen_unlocks' => $row->number_of_screen_unlocks,
                'day_type' => $row->day_type,
                'non_interactive_mode_time' => $row->non_interactive_mode_time,
                'reading_time' => $row->reading_time,
                'playing_time' => $row->playing_time,
                'insta_time' => $row->insta_time,
                'note' => $row->note,
            ];
        }

        return $dailyMobilesByDayNumber;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(day_number)) FROM daily_mobile WHERE month = ? AND year = ?',
                $month,
                $year)
            ->fetchSingle();

        return $numberOfRecords;
    }

    public function getNumberOfRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getNumberOfRecords($i, $year);
        }

        return $returnData;
    }

    public function getTotalSpentTime(int $month, int $year): int
    {
        $screenUsageTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(screen_usage_time) FROM daily_mobile WHERE month = ? AND year = ?', $month, $year)->fetchSingle();

        $nonInteractiveModeTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(non_interactive_mode_time) FROM daily_mobile WHERE month = ? AND year = ?', $month, $year)->fetchSingle();

        $readingTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(reading_time) FROM daily_mobile WHERE month = ? AND year = ?', $month, $year)->fetchSingle();

        $totalTime = $screenUsageTime - $nonInteractiveModeTime - $readingTime;

        return $totalTime;
    }

    public function getTotalSpentTimeForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalSpentTime($i, $year);
        }

        return $returnData;
    }

    public function getTotalNumberOfUnlocks(int $month, int $year): int
    {
        $numberOfUnlocks = (int) $this->getDbConnection()
            ->query('SELECT SUM(number_of_screen_unlocks) FROM daily_mobile WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $numberOfUnlocks;
    }

    public function getTotalNumberOfScreenUnlocks(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalNumberOfUnlocks($i, $year);
        }

        return $returnData;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_mobile WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function getTotalSpentTimeByCreated($created): int
    {
        $screenUsageTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(screen_usage_time) FROM daily_mobile WHERE created = ?', $created)->fetchSingle();

        $nonInteractiveModeTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(non_interactive_mode_time) FROM daily_mobile WHERE created = ?', $created)->fetchSingle();

        $totalTime = $screenUsageTime - $nonInteractiveModeTime;

        return $totalTime;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyMobiles = [];

        foreach ($rows as $row) {
            $dailyMobile = new DailyMobile(
                (int)$row->screen_usage_time,
                (int)$row->number_of_screen_unlocks,
                (string)$row->day_type,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailyMobile->setId((int)$row->id);
            $dailyMobile->setNonInteractiveModeTime($row->non_interactive_mode_time);
            $dailyMobile->setReadingTime($row->reading_time);
            $dailyMobile->setPlayingTime($row->playing_time);
            $dailyMobile->setInstaTime($row->insta_time);
            $dailyMobile->setNote($row->note);

            $dailyMobiles[] = $dailyMobile;
        }

        return $dailyMobiles;
    }
}