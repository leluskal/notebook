<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\TransportType\TransportTypeForm;
use App\AdminModule\Components\Forms\TransportType\TransportTypeFormFactory;
use App\Model\TransportType\TransportTypeRepository;
use App\Presenters\BaseAuthorizedPresenter;

class TransportTypePresenter extends BaseAuthorizedPresenter
{
    /**
     * @var TransportTypeRepository
     */
    private $transportTypeRepository;

    /**
     * @var TransportTypeFormFactory
     */
    private $transportTypeFormFactory;

    public function __construct(
        TransportTypeRepository $transportTypeRepository,
        TransportTypeFormFactory $transportTypeFormFactory
    )
    {
        $this->transportTypeRepository = $transportTypeRepository;
        $this->transportTypeFormFactory = $transportTypeFormFactory;
    }

    public function renderDefault()
    {
        $this->template->transportTypes = $this->transportTypeRepository->findAll();
    }

    public function createComponentTransportTypeForm(): TransportTypeForm
    {
        return $this->transportTypeFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $transportType = $this->transportTypeRepository->getById($id);

        $this->template->transportType = $transportType;

        $this['transportTypeForm']['form']['id']->setDefaultValue($transportType->getId());
        $this['transportTypeForm']['form']['name']->setDefaultValue($transportType->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteTransportType(int $id)
    {
        $this->transportTypeRepository->deleteById($id);

        $this->flashMessage('The transport type is deleted', 'info');
        $this->redirect('TransportType:default');
    }
}