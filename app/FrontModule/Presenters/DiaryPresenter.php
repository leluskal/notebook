<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Diary\DiaryForm;
use App\FrontModule\Components\Forms\Diary\DiaryFormFactory;
use App\Model\Diary\DiaryRepository;

class DiaryPresenter extends BasePresenter
{
    /**
     * @var DiaryRepository
     */
    private $diaryRepository;

    /**
     * @var DiaryFormFactory
     */
    private $diaryFormFactory;

    public function __construct(DiaryRepository $diaryRepository, DiaryFormFactory $diaryFormFactory)
    {
        $this->diaryRepository = $diaryRepository;
        $this->diaryFormFactory = $diaryFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function renderDefault($month = null)
    {
        $this->template->months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $this->template->diaries = $this->diaryRepository->findAllGroupedByMonth($month, (int) $this->year);

        $this->template->year = $this->year;
    }

    public function createComponentDiaryForm(): DiaryForm
    {
        return $this->diaryFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $diary = $this->diaryRepository->getById($id);
        $this->template->diary = $diary;

        $this['diaryForm']['form']['id']->setDefaultValue($diary->getId());
        $this['diaryForm']['form']['heading']->setDefaultValue($diary->getHeading());
        $this['diaryForm']['form']['notes']->setDefaultValue($diary->getNotes());
        $this['diaryForm']['form']['month']->setDefaultValue($diary->getMonth());
        $this['diaryForm']['form']['year']->setDefaultValue($diary->getYear());
        $this['diaryForm']['form']['created']->setDefaultValue($diary->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $year)
    {
        $this['diaryForm']['form']['year']->setDefaultValue($year);
    }
}