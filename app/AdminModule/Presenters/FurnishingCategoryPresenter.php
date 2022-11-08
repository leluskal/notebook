<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\FurnishingCategory\FurnishingCategoryForm;
use App\AdminModule\Components\Forms\FurnishingCategory\FurnishingCategoryFormFactory;
use App\FrontModule\Presenters\BasePresenter;
use App\Model\FurnishingCategory\FurnishingCategoryRepository;

class FurnishingCategoryPresenter extends BasePresenter
{
    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    /**
     * @var FurnishingCategoryFormFactory
     */
    private $furnishingCategoryFormFactory;

    public function __construct(
        FurnishingCategoryRepository $furnishingCategoryRepository,
        FurnishingCategoryFormFactory $furnishingCategoryFormFactory
    )
    {
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
        $this->furnishingCategoryFormFactory = $furnishingCategoryFormFactory;
    }

    public function renderDefault()
    {
        $this->template->categories = $this->furnishingCategoryRepository->findAll();
    }

    public function createComponentFurnishingCategoryForm(): FurnishingCategoryForm
    {
        return $this->furnishingCategoryFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $category = $this->furnishingCategoryRepository->getById($id);
        $this->template->category = $category;

        $this['furnishingCategoryForm']['form']['id']->setDefaultValue($category->getId());
        $this['furnishingCategoryForm']['form']['name']->setDefaultValue($category->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteFurnishingCategory(int $id)
    {
        $this->furnishingCategoryRepository->deleteById($id);

        $this->flashMessage('The category is deleted', 'info');
        $this->redirect('FurnishingCategory:default');
    }
}