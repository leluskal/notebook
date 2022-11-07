<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Movie;

use App\FrontModule\Components\Forms\Movie\MovieForm;
use App\Model\Genre\GenreRepository;
use App\Model\Movie\MovieRepository;
use App\Model\MovieGenre\MovieGenreRepository;

class MovieFormFactory
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * @var GenreRepository
     */
    private $genreRepository;

    /**
     * @var MovieGenreRepository
     */
    private $movieGenreRepository;

    public function __construct(
        MovieRepository $movieRepository,
        GenreRepository $genreRepository,
        MovieGenreRepository $movieGenreRepository
    )
    {
        $this->movieRepository = $movieRepository;
        $this->genreRepository = $genreRepository;
        $this->movieGenreRepository = $movieGenreRepository;
    }

    public function create(): MovieForm
    {
        return new MovieForm($this->movieRepository, $this->genreRepository, $this->movieGenreRepository);
    }
}