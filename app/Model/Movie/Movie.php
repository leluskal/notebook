<?php
declare(strict_types=1);

namespace App\Model\Movie;

class Movie
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
    private $countryOfOrigin;

    /**
     * @var int
     */
    private $releaseYear;

    /**
     * @var int|null
     */
    private $rating;

    /**
     * @var int
     */
    private $seen;

    /**
     * @var int
     */
    private $year;

    /**
     * @var array
     */
    private $genreIds;

    /**
     * @var array
     */
    private $genreNames;

    public function __construct(string $name, string $countryOfOrigin, int $releaseYear, int $seen, int $year)
    {
        $this->name = $name;
        $this->countryOfOrigin = $countryOfOrigin;
        $this->releaseYear = $releaseYear;
        $this->seen = $seen;
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

    public function getCountryOfOrigin(): string
    {
        return $this->countryOfOrigin;
    }

    public function setCountryOfOrigin(string $countryOfOrigin): void
    {
        $this->countryOfOrigin = $countryOfOrigin;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getSeen(): int
    {
        return $this->seen;
    }

    public function setSeen(int $seen): void
    {
        $this->seen = $seen;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getGenreIds(): array
    {
        return $this->genreIds;
    }

    public function setGenreIds(array $genreIds): void
    {
        $this->genreIds = $genreIds;
    }

    public function getGenreNames(): array
    {
        return $this->genreNames;
    }

    public function setGenreNames(array $genreNames): void
    {
        $this->genreNames = $genreNames;
    }
}