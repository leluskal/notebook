<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Genre;

use App\Model\Genre\GenreRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class GenreForm extends Control
{
    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Genre')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->genreRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new genre is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->genreRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The genre is updated', 'info');
        }

        $this->getPresenter()->redirect('Genre:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/genreForm.latte');
        $template->render();
    }
}