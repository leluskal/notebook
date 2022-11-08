<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Furnishing\FurnishingForm;
use App\FrontModule\Components\Forms\Furnishing\FurnishingFormFactory;
use App\Model\Furnishing\FurnishingRepository;
use App\Model\FurnishingCategory\FurnishingCategoryRepository;
use App\Model\FurnishingLink\FurnishingLinkRepository;
use App\Model\FurnishingLink\FurnishingLinkService;

class FurnishingPresenter extends BasePresenter
{
    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    /**
     * @var FurnishingFormFactory
     */
    private $furnishingFormFactory;

    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    /**
     * @var FurnishingLinkRepository
     */
    private $furnishingLinkRepository;

    /**
     * @var FurnishingLinkService
     */
    private $furnishingLinkService;

    public function __construct(
        FurnishingRepository $furnishingRepository,
        FurnishingFormFactory $furnishingFormFactory,
        FurnishingCategoryRepository $furnishingCategoryRepository,
        FurnishingLinkRepository $furnishingLinkRepository,
        FurnishingLinkService $furnishingLinkService
    )
    {
        $this->furnishingRepository = $furnishingRepository;
        $this->furnishingFormFactory = $furnishingFormFactory;
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
        $this->furnishingLinkRepository = $furnishingLinkRepository;
        $this->furnishingLinkService = $furnishingLinkService;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }

    public function renderDefault($furnishingCategoryId = null)
    {
        $furnishingsByCategories = $this->furnishingRepository->findAllByFurnishingCategoryId((int) $furnishingCategoryId);

        if ($furnishingCategoryId !== null) {
            $this->template->furnishingByCategories = $furnishingsByCategories;
        }

        $this->template->furnishingCategories = $this->furnishingCategoryRepository->findAll();
        $this->template->furnishingCategoryId = $furnishingCategoryId;
    }

    public function createComponentFurnishingForm(): FurnishingForm
    {
        return $this->furnishingFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $furnishing = $this->furnishingRepository->getById($id);
        $this->template->furnishing = $furnishing;

        $this['furnishingForm']['form']['id']->setDefaultValue($furnishing->getId());
        $this['furnishingForm']['form']['furnishing_category_id']->setDefaultValue($furnishing->getFurnishingCategoryId());
        $this['furnishingForm']['form']['name']->setDefaultValue($furnishing->getName());
        $this['furnishingForm']['form']['note']->setDefaultValue($furnishing->getNote());
    }

    public function renderCreate(int $furnishingCategoryId)
    {
        $this['furnishingForm']['form']['furnishing_category_id']->setDefaultValue($furnishingCategoryId);
    }

    public function renderDetail(int $furnishingId, string $type = null)
    {
        $furnishing = $this->furnishingRepository->getById($furnishingId);
        $this->template->furnishing = $furnishing;

        if ($type === 'toBuy') {
            $furnishingLinks = $this->furnishingLinkRepository->findAllUnBoughtByFurnishingId($furnishingId);
            $furnishingLinks = $this->furnishingLinkService->mapEntitiesToArray($furnishingLinks);
            $this->template->furnishingLinks = $furnishingLinks;
        }

        if ($type === 'purchased') {
            $furnishingLinks = $this->furnishingLinkRepository->findAllBoughtByFurnishingId($furnishingId);
            $furnishingLinks = $this->furnishingLinkService->mapEntitiesToArray($furnishingLinks);
            $this->template->furnishingLinks = $furnishingLinks;
        }

        $this->template->type = $type;
    }
}