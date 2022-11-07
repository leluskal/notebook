<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Book;

use App\Model\Book\BookRepository;

class BookFormFactory
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function create(): BookForm
    {
        return new BookForm($this->bookRepository);
    }
}