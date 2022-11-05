<?php
declare(strict_types=1);

namespace App\Model\DailyWorkout;

use App\Model\BaseRepository;

class DailyWorkoutRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_workout';
    }

    public function getById(int $id): ?DailyWorkout
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_workout WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $dailyWorkout = new DailyWorkout(
            (int)$row->fitness_instructor_id,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyWorkout->setId((int)$row->id);
        $dailyWorkout->setWorkoutTime($row->workout_time);
        $dailyWorkout->setNote($row->note);

        return $dailyWorkout;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyWorkout
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_workout WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyWorkout = new DailyWorkout(
            (int)$row->fitness_instructor_id,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyWorkout->setId((int)$row->id);
        $dailyWorkout->setWorkoutTime($row->workout_time);
        $dailyWorkout->setNote($row->note);

        return $dailyWorkout;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_workout WHERE month = ? AND year = ?',
                $month,
                $year)
            ->fetchAll();

        $dailyWorkoutsByDayNumber = [];

        foreach ($rows as $row) {
            $dailyWorkoutsByDayNumber[$row->day_number] = [
                'workout_time' => $row->workout_time,
                'illness' => $row->illness,
                'note' => $row->note,
            ];
        }

        return $dailyWorkoutsByDayNumber;
    }

    public function findAllInstructorsByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT dw.*, fi.name FROM daily_workout dw LEFT JOIN fitness_instructor fi ON dw.fitness_instructor_id = fi.id 
                            WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $fitnessInstructorsByDayNumber = [];

        foreach ($rows as $row) {
//            $fitnessInstructorsByDayNumber[$row->day_number][] = $row->name . ' (' . $row->workout_time . ' min)';
            $fitnessInstructorsByDayNumber[$row->day_number][] = [
                'id' => $row->id,
                'name' => $row->name,
                'workout_time' => $row->workout_time,
            ];
        }

        return $fitnessInstructorsByDayNumber;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyWorkouts = [];

        foreach ($rows as $row) {
            $dailyWorkout = new DailyWorkout(
                (int)$row->fitness_instructor_id,
                (int)$row->illness,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailyWorkout->setId((int)$row->id);
            $dailyWorkout->setWorkoutTime($row->workout_time);
            $dailyWorkout->setNote($row->note);

            $dailyWorkouts[] = $dailyWorkout;
        }

        return $dailyWorkouts;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(day_number)) FROM daily_workout WHERE month = ? AND year = ? AND illness = 0 AND menstruation = 0',
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

    public function getTotalWorkoutTime(int $month, int $year): int
    {
        $totalTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(workout_time) FROM daily_workout WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $totalTime;
    }

    public function getTotalWorkoutTimeForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalWorkoutTime($i, $year);
        }

        return $returnData;
    }

    public function getTotalWorkoutTimeByCreated($created): int
    {
        $totalTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(workout_time) FROM daily_workout WHERE created = ?', $created)
            ->fetchSingle();

        return $totalTime;

    }

}