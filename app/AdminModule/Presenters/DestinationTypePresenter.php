<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\DestinationType\DestinationTypeForm;
use App\AdminModule\Components\Forms\DestinationType\DestinationTypeFormFactory;
use App\Model\DestinationType\DestinationTypeRepository;
use App\Presenters\BaseAuthorizedPresenter;

class DestinationTypePresenter extends BaseAuthorizedPresenter
{
    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    /**
     * @var DestinationTypeFormFactory
     */
    private $destinationTypeFormFactory;

    public function __construct(
        DestinationTypeRepository $destinationTypeRepository,
        DestinationTypeFormFactory $destinationTypeFormFactory
    )
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
        $this->destinationTypeFormFactory = $destinationTypeFormFactory;
    }

    public function renderDefault()
    {
        $this->template->destinationTypes = $this->destinationTypeRepository->findAll();
    }

    public function createComponentDestinationTypeForm(): DestinationTypeForm
    {
        return $this->destinationTypeFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $destinationType = $this->destinationTypeRepository->getById($id);

        $this->template->destinationType = $destinationType;

        $this['destinationTypeForm']['form']['id']->setDefaultValue($destinationType->getId());
        $this['destinationTypeForm']['form']['name']->setDefaultValue($destinationType->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteDestinationType(int $id)
    {
        $this->destinationTypeRepository->deleteById($id);

        $this->flashMessage('The record of destination type is deleted', 'info');
        $this->redirect('DestinationType:default');
    }
}