<?php
declare(strict_types=1);

namespace App\Model\Book;

use App\Model\BaseRepository;

class BookRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'book';
    }

    public function getById(int $id): ?Book
    {
        $row = $this->getDbConnection()->query('SELECT * FROM book WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $book = new Book(
            (string)$row->name,
            (string)$row->author,
            (int)$row->number_of_pages,
            (int)$row->book_reader,
            (int)$row->read,
            (int)$row->year
        );
        $book->setId((int)$row->id);
        $book->setDateReadingStart($row->date_reading_start);
        $book->setDateReadingEnd($row->date_reading_end);
        $book->setRating($row->rating);

        return $book;
    }

    public function findAllByYear(int $year): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM book WHERE year = ?', $year)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $books = [];

        foreach ($rows as $row) {
            $book = new Book(
                (string)$row->name,
                (string)$row->author,
                (int)$row->number_of_pages,
                (int)$row->book_reader,
                (int)$row->read,
                (int)$row->year
            );
            $book->setId((int)$row->id);
            $book->setDateReadingStart($row->date_reading_start);
            $book->setDateReadingEnd($row->date_reading_end);
            $book->setRating($row->rating);

            $books[] = $book;
        }

        return $books;
    }

    public function getNumberOfReadBooks(int $year): int
    {
        $numberOfReadBooks = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(id)) FROM book WHERE year = ? AND `read` = 1', $year)
            ->fetchSingle();

        return $numberOfReadBooks;
    }
}