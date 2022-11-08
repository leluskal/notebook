<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Diary;

use App\Model\Diary\DiaryRepository;

class DiaryFormFactory
{
    /**
     * @var DiaryRepository
     */
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

    public function create(): DiaryForm
    {
        return new DiaryForm($this->diaryRepository);
    }
}