<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Movie\MovieForm;
use App\FrontModule\Components\Forms\Movie\MovieFormFactory;
use App\Model\Movie\MovieRepository;
use App\Model\Movie\MovieService;
use App\Model\MovieGenre\MovieGenreRepository;

class MoviePresenter extends BasePresenter
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * @var MovieFormFactory
     */
    private $movieFormFactory;

    /**
     * @var MovieGenreRepository
     */
    private $movieGenreRepository;

    /**
     * @var MovieService
     */
    private $movieService;

    public function __construct(
        MovieRepository $movieRepository,
        MovieFormFactory $movieFormFactory,
        MovieGenreRepository $movieGenreRepository,
        MovieService $movieService
    )
    {
        $this->movieRepository = $movieRepository;
        $this->movieFormFactory = $movieFormFactory;
        $this->movieGenreRepository = $movieGenreRepository;
        $this->movieService = $movieService;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }

    public function renderDefault()
    {
        $movies = $this->movieRepository->findAllByYear((int) $this->year);
        $this->template->movies = $this->movieService->fillGenreIds($movies);

        $this->template->year = $this->year;
    }

    public function createComponentMovieForm(): MovieForm
    {
        return $this->movieFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $movie = $this->movieRepository->getById($id);

        $this->template->movie = $movie;

        $this['movieForm']['form']['id']->setDefaultValue($movie->getId());
        $this['movieForm']['form']['name']->setDefaultValue($movie->getName());
        $this['movieForm']['form']['country_of_origin']->setDefaultValue($movie->getCountryOfOrigin());
        $this['movieForm']['form']['release_year']->setDefaultValue($movie->getReleaseYear());
        $this['movieForm']['form']['rating']->setDefaultValue($movie->getRating());
        $this['movieForm']['form']['seen']->setDefaultValue($movie->getSeen());
        $this['movieForm']['form']['year']->setDefaultValue($movie->getYear());
        $genreIds = $this->movieGenreRepository->getAllGenreIdsByMovieId($movie->getId());
        $this['movieForm']['form']['genre_ids']->setDefaultValue($genreIds);
    }

    public function renderCreate(int $year)
    {
        $this['movieForm']['form']['year']->setDefaultValue($year);
    }
}