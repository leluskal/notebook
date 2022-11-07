<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Entertainment\EntertainmentForm;
use App\FrontModule\Components\Forms\Entertainment\EntertainmentFormFactory;
use App\Model\Entertainment\EntertainmentRepository;
use App\Model\Entertainment\EntertainmentService;

class EntertainmentPresenter extends BasePresenter
{
    /**
     * @var EntertainmentRepository
     */
    private $entertainmentRepository;

    /**
     * @var EntertainmentFormFactory
     */
    private $entertainmentFormFactory;

    /**
     * @var EntertainmentService
     */
    private $entertainmentService;

    public function __construct(
        EntertainmentRepository $entertainmentRepository,
        EntertainmentFormFactory $entertainmentFormFactory,
        EntertainmentService $entertainmentService
    )
    {
        $this->entertainmentRepository = $entertainmentRepository;
        $this->entertainmentFormFactory = $entertainmentFormFactory;
        $this->entertainmentService = $entertainmentService;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
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

        $entertainments = $this->entertainmentService->findAllGroupedByMonth((int) $this->year, $month);

        $this->template->entertainments = $entertainments;
        $this->template->year = $this->year;
    }

    public function createComponentEntertainmentForm(): EntertainmentForm
    {
        return $this->entertainmentFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $entertainment = $this->entertainmentRepository->getById($id);

        $this->template->entertainment = $entertainment;

        $this['entertainmentForm']['form']['id']->setDefaultValue($entertainment->getId());
        $this['entertainmentForm']['form']['entertainment_type_id']->setDefaultValue($entertainment->getEntertainmentTypeId());
        $this['entertainmentForm']['form']['month']->setDefaultValue($entertainment->getMonth());
        $this['entertainmentForm']['form']['date']->setDefaultValue($entertainment->getDate()->format('Y-m-d'));
        $this['entertainmentForm']['form']['details']->setDefaultValue($entertainment->getDetails());
        $this['entertainmentForm']['form']['year']->setDefaultValue($entertainment->getYear());
        $this['entertainmentForm']['form']['rating']->setDefaultValue($entertainment->getRating());
    }

    public function renderCreate(int $year)
    {
        $this['entertainmentForm']['form']['year']->setDefaultValue($year);
    }

    public function handleDeleteEntertainment(int $id)
    {
        $this->entertainmentRepository->deleteById($id);

        $this->flashMessage('The record of entertainment is deleted', 'info');
        $this->redirect('Entertainment:default');
    }

}