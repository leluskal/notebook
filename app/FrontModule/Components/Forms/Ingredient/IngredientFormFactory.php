<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Ingredient;

use App\Model\Ingredient\IngredientRepository;

class IngredientFormFactory
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function create(): IngredientForm
    {
        return new IngredientForm($this->ingredientRepository);
    }
}