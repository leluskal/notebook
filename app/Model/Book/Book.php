<?php
declare(strict_types=1);

namespace App\Model\Book;

class Book
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $author;

    /**
     * @var int
     */
    private $numberOfPages;

    private $dateReadingStart;

    private $dateReadingEnd;

    /**
     * @var int
     */
    private $bookReader;

    /**
     * @var int
     */
    private $read;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int|null
     */
    private $rating;

    public function __construct(string $name, string $author, int $numberOfPages, int $bookReader, int $read, int $year)
    {
        $this->name = $name;
        $this->author = $author;
        $this->numberOfPages = $numberOfPages;
        $this->bookReader = $bookReader;
        $this->read = $read;
        $this->year = $year;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getNumberOfPages(): int
    {
        return $this->numberOfPages;
    }

    public function setNumberOfPages(int $numberOfPages): void
    {
        $this->numberOfPages = $numberOfPages;
    }

    public function getDateReadingStart()
    {
        return $this->dateReadingStart;
    }

    public function setDateReadingStart($dateReadingStart): void
    {
        $this->dateReadingStart = $dateReadingStart;
    }

    public function getDateReadingEnd()
    {
        return $this->dateReadingEnd;
    }

    public function setDateReadingEnd($dateReadingEnd): void
    {
        $this->dateReadingEnd = $dateReadingEnd;
    }

    public function getBookReader(): int
    {
        return $this->bookReader;
    }

    public function setBookReader(int $bookReader): void
    {
        $this->bookReader = $bookReader;
    }

    public function getRead(): int
    {
        return $this->read;
    }

    public function setRead(int $read): void
    {
        $this->read = $read;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }
}