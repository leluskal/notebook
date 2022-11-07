<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Movie;

use App\Model\Genre\GenreRepository;
use App\Model\Movie\MovieRepository;
use App\Model\MovieGenre\MovieGenreRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class MovieForm extends Control
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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Movie')
            ->setRequired('The name is required');

        $form->addText('country_of_origin', 'Country Of Origin')
            ->setRequired('The country is required');

        $form->addInteger('release_year', 'Release Year')
            ->setRequired('The year is required');

        $form->addMultiSelect('genre_ids', 'Genre', $this->genreRepository->findAllForSelectBox());

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
            ->setPrompt('--Choose stars--');

        $form->addCheckbox('seen', 'Seen');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->movieRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of movie is deleted','info');
            $this->getPresenter()->redirect('Movie:default');
        }

        if ($values->id === '') {
            $movie = $this->movieRepository->create([
                'name' => $values->name,
                'country_of_origin' => $values->country_of_origin,
                'release_year' => $values->release_year,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'seen' => $values->seen,
                'year' => $values->year
            ]);

            foreach ($values->genre_ids as $genreId) {
                $this->movieGenreRepository->create([
                    'movie_id' => $movie->getId(),
                    'genre_id' => $genreId
                ]);

                bdump($movie);
            }
            $this->getPresenter()->flashMessage('The new movie is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
                'country_of_origin' => $values->country_of_origin,
                'release_year' => $values->release_year,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'seen' => $values->seen,
                'year' => $values->year
            ];

            $this->movieGenreRepository->deleteAllByMovieId((int) $values->id);

            foreach ($values->genre_ids as $genreId) {
                $this->movieGenreRepository->create([
                    'movie_id' => $values->id,
                    'genre_id' => $genreId
                ]);
            }

            $this->movieRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record movie is updated', 'info');
        }

        $this->getPresenter()->redirect('Movie:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/movieForm.latte');
        $template->render();
    }
}