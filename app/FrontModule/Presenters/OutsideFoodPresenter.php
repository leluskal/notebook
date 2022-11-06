<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\OutsideFood\OutsideFoodForm;
use App\FrontModule\Components\Forms\OutsideFood\OutsideFoodFormFactory;
use App\Model\OutsideFood\OutsideFoodRepository;

class OutsideFoodPresenter extends BasePresenter
{
    /**
     * @var OutsideFoodRepository
     */
    private $outsideFoodRepository;

    /**
     * @var OutsideFoodFormFactory
     */
    private $outsideFoodFormFactory;

    public function __construct(
        OutsideFoodRepository $outsideFoodRepository,
        OutsideFoodFormFactory $outsideFoodFormFactory
    )
    {
        $this->outsideFoodRepository = $outsideFoodRepository;
        $this->outsideFoodFormFactory = $outsideFoodFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'OutsideFood:default';
        $this->template->menuMonthsCssClass = 'outside-food-menu';
    }

    public function renderDefault()
    {
        $this->template->outsideFoodByDayNumber = $this->outsideFoodRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentOutsideFoodForm(): OutsideFoodForm
    {
        return $this->outsideFoodFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $outsideFood = $this->outsideFoodRepository->getById($id);

        $this->template->nonCookedFoodRecord = $outsideFood;

        $this['outsideFoodForm']['form']['id']->setDefaultValue($outsideFood->getId());
        $this['outsideFoodForm']['form']['food']->setDefaultValue($outsideFood->getFood());
        $this['outsideFoodForm']['form']['price']->setDefaultValue($outsideFood->getPrice());
        $this['outsideFoodForm']['form']['note']->setDefaultValue($outsideFood->getNote());
        $this['outsideFoodForm']['form']['food_delivery']->setDefaultValue($outsideFood->getFoodDelivery());
        $this['outsideFoodForm']['form']['drink']->setDefaultValue($outsideFood->getDrink());
        $this['outsideFoodForm']['form']['day_number']->setDefaultValue($outsideFood->getDayNumber());
        $this['outsideFoodForm']['form']['month']->setDefaultValue($outsideFood->getMonth());
        $this['outsideFoodForm']['form']['year']->setDefaultValue($outsideFood->getYear());
        $this['outsideFoodForm']['form']['created']->setDefaultValue($outsideFood->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $dayNumber)
    {
        $this['outsideFoodForm']['form']['day_number']->setDefaultValue($dayNumber);
        $this['outsideFoodForm']['form']['month']->setDefaultValue((int) $this->month);
        $this['outsideFoodForm']['form']['year']->setDefaultValue((int) $this->year);
    }
}