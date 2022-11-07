<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\ReadBook\ReadBookForm;
use App\FrontModule\Components\Forms\ReadBook\ReadBookFormFactory;
use App\Model\ReadBook\ReadBookRepository;

class ReadBookPresenter extends BasePresenter
{
    /**
     * @var ReadBookRepository
     */
    private $readBookRepository;

    /**
     * @var ReadBookFormFactory
     */
    private $readBookFormFactory;

    public function __construct(ReadBookRepository $readBookRepository, ReadBookFormFactory $readBookFormFactory)
    {
        $this->readBookRepository = $readBookRepository;
        $this->readBookFormFactory = $readBookFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }

    public function renderDefault()
    {
        $this->template->readBooks = $this->readBookRepository->findAllByYear((int) $this->year);
        $this->template->numberOfReadBooks = $this->readBookRepository->getNumberOfReadBooks((int) $this->year);

        $this->template->year = $this->year;
    }

    public function createComponentReadBookForm(): ReadBookForm
    {
        return $this->readBookFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $readBook = $this->readBookRepository->getById($id);

        $this->template->readBook = $readBook;

        $dateReadingStart = $readBook->getDateReadingStart() ? $readBook->getDateReadingStart()->format('Y-m-d') : '';
        $dateReadingEnd = $readBook->getDateReadingEnd() ? $readBook->getDateReadingEnd()->format('Y-m-d') : '';

        $this['readBookForm']['form']['id']->setDefaultValue($readBook->getId());
        $this['readBookForm']['form']['name']->setDefaultValue($readBook->getName());
        $this['readBookForm']['form']['author']->setDefaultValue($readBook->getAuthor());
        $this['readBookForm']['form']['number_of_pages']->setDefaultValue($readBook->getNumberOfPages());
        $this['readBookForm']['form']['date_reading_start']->setDefaultValue($dateReadingStart);
        $this['readBookForm']['form']['date_reading_end']->setDefaultValue($dateReadingEnd);
        $this['readBookForm']['form']['book_reader']->setDefaultValue($readBook->getBookReader());
        $this['readBookForm']['form']['read']->setDefaultValue($readBook->getRead());
        $this['readBookForm']['form']['year']->setDefaultValue($readBook->getYear());
        $this['readBookForm']['form']['rating']->setDefaultValue($readBook->getRating());
    }

    public function renderCreate(int $year)
    {
        $this['readBookForm']['form']['year']->setDefaultValue($year);
    }
}