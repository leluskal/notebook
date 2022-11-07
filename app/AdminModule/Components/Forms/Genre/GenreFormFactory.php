<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Genre;

use App\Model\Genre\GenreRepository;

class GenreFormFactory
{
    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function create(): GenreForm
    {
        return new GenreForm($this->genreRepository);
    }

}