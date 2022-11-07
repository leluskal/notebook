<?php
declare(strict_types=1);

namespace App\Model\Movie;

use App\Model\Genre\Genre;
use App\Model\Genre\GenreRepository;
use App\Model\MovieGenre\MovieGenre;
use App\Model\MovieGenre\MovieGenreRepository;

class MovieService
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * @var MovieGenreRepository
     */
    private $movieGenreRepository;

    /**
     * @var GenreRepository
     */
    private $genreRepository;


    public function __construct(
        MovieRepository $movieRepository,
        MovieGenreRepository $movieGenreRepository,
        GenreRepository $genreRepository
    )
    {
        $this->movieRepository = $movieRepository;
        $this->movieGenreRepository = $movieGenreRepository;
        $this->genreRepository = $genreRepository;
    }


    public function fillGenreIds(array $movies): array
    {
        $returnArray = [];

        /** @var Movie $movie */
        foreach ($movies as $movie) {
            $genreIds = $this->movieGenreRepository->getAllGenreIdsByMovieId($movie->getId());
            $movie->setGenreIds($genreIds);

            $genreNamesArray = [];
            foreach ($genreIds as $genreId) {
               $genre = $this->genreRepository->getById($genreId);
               $genreNamesArray[] = $genre->getName();
            }

            $movie->setGenreNames($genreNamesArray);

            $returnArray[] = $movie;
        }

        return $returnArray;
    }
}