<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\ShoppingCart;

use App\Model\ShoppingCart\ShoppingCartRepository;

class ShoppingCartFormFactory
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function create(): ShoppingCartForm
    {
        return new ShoppingCartForm($this->shoppingCartRepository);
    }
}