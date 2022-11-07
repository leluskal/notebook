<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Book\BookForm;
use App\FrontModule\Components\Forms\Book\BookFormFactory;
use App\Model\Book\BookRepository;

class BookPresenter extends BasePresenter
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @var BookFormFactory
     */
    private $bookFormFactory;

    public function __construct(BookRepository $bookRepository, BookFormFactory $bookFormFactory)
    {
        $this->bookRepository = $bookRepository;
        $this->bookFormFactory = $bookFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }

    public function renderDefault()
    {
        $this->template->books = $this->bookRepository->findAllByYear((int) $this->year);
        $this->template->numberOfReadBooks = $this->bookRepository->getNumberOfReadBooks((int) $this->year);

        $this->template->year = $this->year;
    }

    public function createComponentBookForm(): BookForm
    {
        return $this->readBookFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $book = $this->bookRepository->getById($id);

        $this->template->book = $book;

        $dateReadingStart = $book->getDateReadingStart() ? $book->getDateReadingStart()->format('Y-m-d') : '';
        $dateReadingEnd = $book->getDateReadingEnd() ? $book->getDateReadingEnd()->format('Y-m-d') : '';

        $this['bookForm']['form']['id']->setDefaultValue($book->getId());
        $this['bookForm']['form']['name']->setDefaultValue($book->getName());
        $this['bookForm']['form']['author']->setDefaultValue($book->getAuthor());
        $this['bookForm']['form']['number_of_pages']->setDefaultValue($book->getNumberOfPages());
        $this['bookForm']['form']['date_reading_start']->setDefaultValue($dateReadingStart);
        $this['bookForm']['form']['date_reading_end']->setDefaultValue($dateReadingEnd);
        $this['bookForm']['form']['book_reader']->setDefaultValue($book->getBookReader());
        $this['bookForm']['form']['read']->setDefaultValue($book->getRead());
        $this['bookForm']['form']['year']->setDefaultValue($book->getYear());
        $this['bookForm']['form']['rating']->setDefaultValue($book->getRating());
    }

    public function renderCreate(int $year)
    {
        $this['bookForm']['form']['year']->setDefaultValue($year);
    }
}