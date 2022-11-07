<?php
declare(strict_types=1);

namespace App\Model\MovieGenre;

use App\Model\Genre\Genre;

class MovieGenre
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $movieId;

    /**
     * @var int
     */
    private $genreId;

    /**
     * @var Genre
     */
    private $genre;

    public function __construct(int $movieId, int $genreId)
    {
        $this->movieId = $movieId;
        $this->genreId = $genreId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function setGenreId(int $genreId): void
    {
        $this->genreId = $genreId;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;
    }
}