<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\EntertainmentType\EntertainmentTypeForm;
use App\AdminModule\Components\Forms\EntertainmentType\EntertainmentTypeFormFactory;
use App\Model\EntertainmentType\EntertainmentTypeRepository;
use App\Presenters\BaseAuthorizedPresenter;

class EntertainmentTypePresenter extends BaseAuthorizedPresenter
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    /**
     * @var EntertainmentTypeFormFactory
     */
    private $entertainmentTypeFormFactory;

    public function __construct(
        EntertainmentTypeRepository $entertainmentTypeRepository,
        EntertainmentTypeFormFactory $entertainmentTypeFormFactory
    )
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
        $this->entertainmentTypeFormFactory = $entertainmentTypeFormFactory;
    }

    public function renderDefault()
    {
        $this->template->entertainmentTypes = $this->entertainmentTypeRepository->findAll();
    }

    public function createComponentEntertainmentTypeForm(): EntertainmentTypeForm
    {
        return $this->entertainmentTypeFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $entertainmentType = $this->entertainmentTypeRepository->getById($id);

        $this->template->entertainmentType = $entertainmentType;

        $this['entertainmentTypeForm']['form']['id']->setDefaultValue($entertainmentType->getId());
        $this['entertainmentTypeForm']['form']['name']->setDefaultValue($entertainmentType->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteEntertainmentType(int $id)
    {
        $this->entertainmentTypeRepository->deleteById($id);

        $this->flashMessage('The entertainment type is deleted', 'info');
        $this->redirect('EntertainmentType:default');
    }
}