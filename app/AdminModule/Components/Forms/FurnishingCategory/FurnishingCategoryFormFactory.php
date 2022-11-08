<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\FurnishingCategory;

use App\Model\FurnishingCategory\FurnishingCategoryRepository;

class FurnishingCategoryFormFactory
{
    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    public function __construct(FurnishingCategoryRepository $furnishingCategoryRepository)
    {
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
    }

    public function create(): FurnishingCategoryForm
    {
        return new FurnishingCategoryForm($this->furnishingCategoryRepository);
    }
}