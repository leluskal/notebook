<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\ShoppingCart\ShoppingCartForm;
use App\FrontModule\Components\Forms\ShoppingCart\ShoppingCartFormFactory;
use App\Model\ShoppingCart\ShoppingCartRepository;

class ShoppingCartPresenter extends BasePresenter
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    /**
     * @var ShoppingCartFormFactory
     */
    private $shoppingCartFormFactory;

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository,
        ShoppingCartFormFactory $shoppingCartFormFactory
    )
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->shoppingCartFormFactory = $shoppingCartFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutMonthlyReport');

        $this->template->menuMonthsLink = 'ShoppingCart:default';
        $this->template->menuMonthsCssClass = 'shopping-cart-menu';
    }

    public function renderDefault()
    {
        $this->template->shoppingCartsByDayNumber = $this->shoppingCartRepository->findAllByMonthAndYear(
            (int) $this->month,
            (int) $this->year
        );

        $this->template->year = $this->year;
    }

    public function createComponentShoppingCartForm(): ShoppingCartForm
    {
        return $this->shoppingCartFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $shoppingCart = $this->shoppingCartRepository->getById($id);

        $this->template->shoppingCart = $shoppingCart;

        $this['shoppingCartForm']['form']['id']->setDefaultValue($shoppingCart->getId());
        $this['shoppingCartForm']['form']['shop']->setDefaultValue($shoppingCart->getShop());
        $this['shoppingCartForm']['form']['price']->setDefaultValue($shoppingCart->getPrice());
        $this['shoppingCartForm']['form']['day_number']->setDefaultValue($shoppingCart->getDayNumber());
        $this['shoppingCartForm']['form']['month']->setDefaultValue($shoppingCart->getMonth());
        $this['shoppingCartForm']['form']['year']->setDefaultValue($shoppingCart->getYear());
        $this['shoppingCartForm']['form']['note']->setDefaultValue($shoppingCart->getNote());
        $this['shoppingCartForm']['form']['created']->setDefaultValue($shoppingCart->getCreated()->format('Y-m-d'));
    }

    public function renderCreate(int $dayNumber)
    {
        $this['shoppingCartForm']['form']['day_number']->setDefaultValue($dayNumber);
        $this['shoppingCartForm']['form']['month']->setDefaultValue((int) $this->month);
        $this['shoppingCartForm']['form']['year']->setDefaultValue((int) $this->year);
    }
}