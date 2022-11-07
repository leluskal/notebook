<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Genre\GenreForm;
use App\AdminModule\Components\Forms\Genre\GenreFormFactory;
use App\Model\Genre\GenreRepository;
use App\Presenters\BaseAuthorizedPresenter;

class GenrePresenter extends BaseAuthorizedPresenter
{
    /**
     * @var GenreRepository
     */
    private $genreRepository;

    /**
     * @var GenreFormFactory
     */
    private $genreFormFactory;

    public function __construct(GenreRepository $genreRepository, GenreFormFactory $genreFormFactory)
    {
        $this->genreRepository = $genreRepository;
        $this->genreFormFactory = $genreFormFactory;
    }

    public function renderDefault()
    {
        $this->template->genres = $this->genreRepository->findAll();
    }

    public function createComponentGenreForm(): GenreForm
    {
        return $this->genreFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $genre = $this->genreRepository->getById($id);

        $this->template->genre = $genre;

        $this['genreForm']['form']['id']->setDefaultValue($genre->getId());
        $this['genreForm']['form']['name']->setDefaultValue($genre->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteGenre(int $id)
    {
        $this->genreRepository->deleteById($id);

        $this->flashMessage('The genre is deleted', 'info');
        $this->redirect('Genre:default');
    }
}