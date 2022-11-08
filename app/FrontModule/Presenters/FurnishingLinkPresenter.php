<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\FurnishingLink\FurnishingLinkForm;
use App\FrontModule\Components\Forms\FurnishingLink\FurnishingLinkFormFactory;
use App\Model\FurnishingLink\FurnishingLinkRepository;

class FurnishingLinkPresenter extends BasePresenter
{
    /**
     * @var FurnishingLinkRepository
     */
    private $furnishingLinkRepository;

    /**
     * @var FurnishingLinkFormFactory
     */
    private $furnishingLinkFormFactory;

    public function __construct(
        FurnishingLinkRepository $furnishingLinkRepository,
        FurnishingLinkFormFactory $furnishingLinkFormFactory
    )
    {
        $this->furnishingLinkRepository = $furnishingLinkRepository;
        $this->furnishingLinkFormFactory = $furnishingLinkFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }

    public function createComponentFurnishingLinkForm(): FurnishingLinkForm
    {
        return $this->furnishingLinkFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $furnishingLink = $this->furnishingLinkRepository->getById($id);
        $this->template->furnishingLink = $furnishingLink;

        $dateOfPurchase = $furnishingLink->getDateOfPurchase() ? $furnishingLink->getDateOfPurchase()->format('Y-m-d') : null;

        $this['furnishingLinkForm']['form']['id']->setDefaultValue($furnishingLink->getId());
        $this['furnishingLinkForm']['form']['furnishing_id']->setDefaultValue($furnishingLink->getFurnishingId());
        $this['furnishingLinkForm']['form']['link']->setDefaultValue($furnishingLink->getLink());
        $this['furnishingLinkForm']['form']['link_name']->setDefaultValue($furnishingLink->getLinkName());
        $this['furnishingLinkForm']['form']['shop']->setDefaultValue($furnishingLink->getShop());
        $this['furnishingLinkForm']['form']['price']->setDefaultValue($furnishingLink->getPrice());
        $this['furnishingLinkForm']['form']['room_id']->setDefaultValue($furnishingLink->getRoomId());
        $this['furnishingLinkForm']['form']['purchased']->setDefaultValue($furnishingLink->getPurchased());
        $this['furnishingLinkForm']['form']['date_of_purchase']->setDefaultValue($dateOfPurchase);
    }

    public function renderCreate(int $furnishingId)
    {
        $this['furnishingLinkForm']['form']['furnishing_id']->setDefaultValue($furnishingId);
    }
}