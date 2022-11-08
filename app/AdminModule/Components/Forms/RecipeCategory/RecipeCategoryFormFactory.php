<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RecipeCategory;

use App\Model\RecipeCategory\RecipeCategoryRepository;

class RecipeCategoryFormFactory
{
    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    public function __construct(RecipeCategoryRepository $recipeCategoryRepository)
    {
        $this->recipeCategoryRepository = $recipeCategoryRepository;
    }

    public function create(): RecipeCategoryForm
    {
        return new RecipeCategoryForm($this->recipeCategoryRepository);
    }
}