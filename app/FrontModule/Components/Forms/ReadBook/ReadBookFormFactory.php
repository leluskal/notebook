<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\ReadBook;

use App\Model\ReadBook\ReadBookRepository;

class ReadBookFormFactory
{
    /**
     * @var ReadBookRepository
     */
    private $readBookRepository;

    public function __construct(ReadBookRepository $readBookRepository)
    {
        $this->readBookRepository = $readBookRepository;
    }

    public function create(): ReadBookForm
    {
        return new ReadBookForm($this->readBookRepository);
    }
}