<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Furnishing;

use App\Model\Furnishing\FurnishingRepository;
use App\Model\FurnishingCategory\FurnishingCategoryRepository;

class FurnishingFormFactory
{
    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    public function __construct(
        FurnishingCategoryRepository $furnishingCategoryRepository,
        FurnishingRepository $furnishingRepository
    )
    {
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
        $this->furnishingRepository = $furnishingRepository;
    }

    public function create(): FurnishingForm
    {
        return new FurnishingForm($this->furnishingCategoryRepository, $this->furnishingRepository);
    }
}