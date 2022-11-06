<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\OutsideFood\OutsideFoodRepository;
use App\Model\ShoppingCart\ShoppingCartRepository;

class FoodSpentMoneyPresenter extends BasePresenter
{
    /**
     * @var OutsideFoodRepository
     */
    private $outsideFoodRepository;

    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    public function __construct(OutsideFoodRepository $outsideFoodRepository, ShoppingCartRepository $shoppingCartRepository)
    {
        $this->outsideFoodRepository = $outsideFoodRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function renderDefault()
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

        $this->template->numberOfRecordsOutsideFood = $this->outsideFoodRepository->getNumberOfFoodRecordsForAllMonths((int) $this->year);
        $this->template->numberOfDrinkRecords = $this->outsideFoodRepository->getNumberOfDrinkRecordsForAllMonths((int) $this->year);
        $this->template->outsideFoodData = $this->outsideFoodRepository->getTotalSpentMoneyForAllMonths((int) $this->year);

        $this->template->numberOfRecordsShoppingCart = $this->shoppingCartRepository->getNumberOfRecordsForAllMonths((int) $this->year);
        $this->template->shoppingCartData = $this->shoppingCartRepository->getTotalSpentMoneyForAllMonths((int) $this->year);

        $this->template->year = $this->year;
    }
}