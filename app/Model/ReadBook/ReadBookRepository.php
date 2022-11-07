<?php
declare(strict_types=1);

namespace App\Model\ReadBook;

use App\Model\BaseRepository;

class ReadBookRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'read_book';
    }

    public function getById(int $id): ?ReadBook
    {
        $row = $this->getDbConnection()->query('SELECT * FROM read_book WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $readBook = new ReadBook(
            (string)$row->name,
            (string)$row->author,
            (int)$row->number_of_pages,
            (int)$row->book_reader,
            (int)$row->read,
            (int)$row->year
        );
        $readBook->setId((int)$row->id);
        $readBook->setDateReadingStart($row->date_reading_start);
        $readBook->setDateReadingEnd($row->date_reading_end);
        $readBook->setRating($row->rating);

        return $readBook;
    }

    public function findAllByYear(int $year): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM read_book WHERE year = ?', $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $readBooks = [];

        foreach ($rows as $row) {
            $readBook = new ReadBook(
                (string)$row->name,
                (string)$row->author,
                (int)$row->number_of_pages,
                (int)$row->book_reader,
                (int)$row->read,
                (int)$row->year
        );
            $readBook->setId((int)$row->id);
            $readBook->setDateReadingStart($row->date_reading_start);
            $readBook->setDateReadingEnd($row->date_reading_end);
            $readBook->setRating($row->rating);

            $readBooks[] = $readBook;
        }

        return $readBooks;
    }

    public function getNumberOfReadBooks(int $year): int
    {
        $numberOfReadBooks = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(id)) FROM read_book WHERE year = ? AND `read` = 1', $year)
            ->fetchSingle();

        return $numberOfReadBooks;
    }
}