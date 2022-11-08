<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\FurnishingExpense\FurnishingExpenseForm;
use App\FrontModule\Components\Forms\FurnishingExpense\FurnishingExpenseFormFactory;
use App\Model\FurnishingExpense\FurnishingExpenseRepository;
use App\Model\FurnishingLink\FurnishingLinkRepository;
use App\Model\FurnishingLink\FurnishingLinkService;

class FurnishingExpensePresenter extends BasePresenter
{
    /**
     * @var FurnishingExpenseRepository
     */
    private $furnishingExpenseRepository;

    /**
     * @var FurnishingExpenseFormFactory
     */
    private $furnishingExpenseFormFactory;

    /**
     * @var FurnishingLinkRepository
     */
    private $furnishingLinkRepository;

    /**
     * @var FurnishingLinkService
     */
    private $furnishingLinkService;

    public function __construct(
        FurnishingExpenseRepository $furnishingExpenseRepository,
        FurnishingExpenseFormFactory $furnishingExpenseFormFactory,
        FurnishingLinkRepository $furnishingLinkRepository,
        FurnishingLinkService $furnishingLinkService
    )
    {
        $this->furnishingExpenseRepository = $furnishingExpenseRepository;
        $this->furnishingExpenseFormFactory = $furnishingExpenseFormFactory;
        $this->furnishingLinkRepository = $furnishingLinkRepository;
        $this->furnishingLinkService = $furnishingLinkService;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }

    public function renderDefault()
    {
        $this->template->furnishingExpenses = $this->furnishingExpenseRepository->findAll();
        $this->template->linksSpentMoney = $this->furnishingLinkRepository->getTotalSpentMoney();
        $this->template->furnishingsSpentMoney = $this->furnishingExpenseRepository->getTotalSpentMoney();
    }

    public function createComponentFurnishingExpenseForm(): FurnishingExpenseForm
    {
        return $this->furnishingExpenseFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $expense = $this->furnishingExpenseRepository->getById($id);
        $this->template->expense = $expense;

        $this['furnishingExpenseForm']['form']['id']->setDefaultValue($expense->getId());
        $this['furnishingExpenseForm']['form']['furnishings']->setDefaultValue($expense->getFurnishings());
        $this['furnishingExpenseForm']['form']['price']->setDefaultValue($expense->getPrice());
        $this['furnishingExpenseForm']['form']['note']->setDefaultValue($expense->getNote());
    }

    public function renderCreate()
    {

    }

    public function renderBoughtFurnishing()
    {
        $boughtFurnishings = $this->furnishingLinkRepository->findAllBoughtFurnishings();
        $boughtFurnishings = $this->furnishingLinkService->mapEntitiesToArray($boughtFurnishings);

        $this->template->boughtFurnishings = $boughtFurnishings;
    }
}