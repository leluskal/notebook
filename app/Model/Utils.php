<?php
declare(strict_types=1);

namespace App\Model;

use DateTime;

class Utils
{
    public static function convertMinutesToTimeString(int $minutes): string
    {
        return intdiv($minutes, 60).' hod '. ($minutes % 60) . ' min';
    }

    public static function getWeekNumberFromDateTime(DateTime $dateTime): int
    {
        return (int) $dateTime->format('W');
    }

    public static function getWeekRangeFromDateTime(DateTime $dateTime): string
    {
        $dayIndex = (int) $dateTime->format('N');

        $mondayDateTime = clone $dateTime;

        if ($dayIndex > 1) {
            $daysModifier = $dayIndex - 1;
            $mondayDateTime->modify('-' . $daysModifier . ' days');
        }

        $sundayDateTime = clone $mondayDateTime;

        if ($dayIndex < 7) {
            $sundayDateTime->modify('+6 days');
        }

        // 5.tyzden (28.2.2022 - 6.3.2022)

        $weekNumber = self::getWeekNumberFromDateTime($dateTime);

        return $weekNumber . '. week (' . $mondayDateTime->format('d.m.Y') . ' - ' . $sundayDateTime->format('d.m.Y') . ')';
    }

    public static function getFirstMondayDateTimeOfYear(int $year): DateTime
    {
        return new DateTime($year . '-01 monday');
    }

    public static function getLastMondayDateTimeOfYear(int $year): DateTime
    {
        return new DateTime($year . '-12 monday');
    }

    public static function getAllWeeks(int $year): array
    {
        $firstMondayOfYearDateTime = self::getFirstMondayDateTimeOfYear($year);

        $returnArray = [1 => self::getWeekRangeFromDateTime($firstMondayOfYearDateTime)];

        for ($w = 2; $w <= 52; $w++) {
            $nextMondayDateTime = $firstMondayOfYearDateTime->modify('+7 days');

            $returnArray[$w] = self::getWeekRangeFromDateTime($nextMondayDateTime);
        }

        return $returnArray;
    }

    public static function getWeekRangeByWeekNumberAndYear(int $weekNumber, int $year): string
    {
        $allWeeks = self::getAllWeeks($year);

        return $allWeeks[$weekNumber];
    }

    public static function getWeekRangeDateTimes(int $weekNumber, int $year): array
    {
        $firstMondayOfYearDateTime = self::getFirstMondayDateTimeOfYear($year);
        $dayCount = $weekNumber * 7 - 7;

        $mondayDateTime = $firstMondayOfYearDateTime->modify('+' . $dayCount . ' days');

        return [
            'Monday' => clone $mondayDateTime,
            'Tuesday' => clone $mondayDateTime->modify('+1 day'),
            'Wednesday' => clone $mondayDateTime->modify('+1 day'),
            'Thursday' => clone $mondayDateTime->modify('+1 day'),
            'Friday' => clone $mondayDateTime->modify('+1 day'),
            'Saturday' => clone $mondayDateTime->modify('+1 day'),
            'Sunday' => clone $mondayDateTime->modify('+1 day'),
        ];
    }

    public static function getMonthsForSelect(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }
}