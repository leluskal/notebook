<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\ApartmentList\ApartmentListForm;
use App\FrontModule\Components\Forms\ApartmentList\ApartmentListFormFactory;
use App\FrontModule\Components\Forms\Task\TaskForm;
use App\FrontModule\Components\Forms\Task\TaskFormFactory;
use App\Model\ApartmentList\ApartmentListRepository;
use App\Model\Task\TaskRepository;
use App\Model\Task\TaskService;

class ApartmentListPresenter extends BasePresenter
{
    /**
     * @var ApartmentListRepository
     */
    private $apartmentListRepository;

    /**
     * @var ApartmentListFormFactory
     */
    private $apartmentListFormFactory;

    public function __construct(
        ApartmentListRepository $apartmentListRepository,
        ApartmentListFormFactory $apartmentListFormFactory
    )
    {
        $this->apartmentListRepository = $apartmentListRepository;
        $this->apartmentListFormFactory = $apartmentListFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }

    public function renderDefault()
    {
        $this->template->apartmentLists = $this->apartmentListRepository->findAll();
    }


    public function createComponentApartmentListForm(): ApartmentListForm
    {
        return $this->apartmentListFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $list = $this->apartmentListRepository->getById($id);

        $this->template->list = $list;

        $this['apartmentListForm']['form']['id']->setDefaultValue($list->getId());
        $this['apartmentListForm']['form']['task']->setDefaultValue($list->getTask());
        $this['apartmentListForm']['form']['done']->setDefaultValue($list->getDone());
    }

    public function renderCreate()
    {

    }
}