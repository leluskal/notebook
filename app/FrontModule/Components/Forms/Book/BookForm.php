<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Book;

use App\Model\Book\BookRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class BookForm extends Control
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Book')
             ->setRequired('The name is required');

        $form->addText('author', 'Author')
             ->setRequired('The author is required');

        $form->addInteger('number_of_pages', 'Number Of Pages')
             ->setRequired('The number of pages is required');

        $form->addText('date_reading_start', 'Reading Start Date')
             ->setHtmlType('date');

        $form->addText('date_reading_end', 'Reading End Date')
             ->setHtmlType('date');

        $form->addCheckbox('book_reader', 'In Book Reader?');

        $form->addCheckbox('read', 'Read?');

        $form->addHidden('year');

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
             ->setPrompt('--Choose stars--');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->bookRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of book is deleted', 'info');
            $this->getPresenter()->redirect('Book:default');
        }

        if ($values->id === '') {
            $this->bookRepository->create([
                'name' => $values->name,
                'author' => $values->author,
                'number_of_pages' => $values->number_of_pages,
                'date_reading_start' => $values->date_reading_start !== '' ? $values->date_reading_start : null,
                'date_reading_end' => $values->date_reading_end !== '' ? $values->date_reading_end : null,
                'book_reader' => $values->book_reader,
                'read' => $values->read,
                'year' => $values->year,
                'rating' => $values->rating !== '' ? $values->rating : null
            ]);
            $this->getPresenter()->flashMessage('The new record of book is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
                'author' => $values->author,
                'number_of_pages' => $values->number_of_pages,
                'date_reading_start' => $values->date_reading_start !== '' ? $values->date_reading_start : null,
                'date_reading_end' => $values->date_reading_end !== '' ? $values->date_reading_end : null,
                'book_reader' => $values->book_reader,
                'read' => $values->read,
                'year' => $values->year,
                'rating' => $values->rating !== '' ? $values->rating : null
            ];

            $this->bookRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of book is updated', 'info');
        }

        $this->getPresenter()->redirect('Book:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/bookForm.latte');
        $template->render();
    }
}