<?php
declare(strict_types=1);

namespace App\Model\Note;

class Note
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $quote;

    private $created;

    /**
     * @var int
     */
    private $year;

    public function __construct(string $text, int $quote, $created, int $year)
    {
        $this->text = $text;
        $this->quote = $quote;
        $this->created = $created;
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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getQuote(): int
    {
        return $this->quote;
    }

    public function setQuote(int $quote): void
    {
        $this->quote = $quote;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): void
    {
        $this->created = $created;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}