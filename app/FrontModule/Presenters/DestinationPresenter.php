<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Destination\DestinationForm;
use App\FrontModule\Components\Forms\Destination\DestinationFormFactory;
use App\Model\Destination\DestinationRepository;
use App\Model\Destination\DestinationService;
use App\Model\DestinationType\DestinationTypeRepository;
use App\Presenters\BaseAuthorizedPresenter;

class DestinationPresenter extends BaseAuthorizedPresenter
{
    /**
     * @var DestinationRepository
     */
    private $destinationRepository;

    /**
     * @var DestinationFormFactory
     */
    private $destinationFormFactory;

    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    public function __construct(
        DestinationRepository $destinationRepository,
        DestinationFormFactory $destinationFormFactory,
        DestinationTypeRepository $destinationTypeRepository
    )
    {
        $this->destinationRepository = $destinationRepository;
        $this->destinationFormFactory = $destinationFormFactory;
        $this->destinationTypeRepository = $destinationTypeRepository;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }

    public function renderDefault(int $destinationTypeId = null)
    {
       $destinationByTypes = $this->destinationRepository->findAllByDestinationTypeId((int) $destinationTypeId);

       $this->template->destinationType = null;

       if ($destinationTypeId !== null) {
           $this->template->destinationByTypes = $destinationByTypes;
           $this->template->destinationType = $this->destinationTypeRepository->getById($destinationTypeId);
       }

       $this->template->destinationTypes = $this->destinationTypeRepository->findAll();
       $this->template->destinationTypeId = $destinationTypeId;
    }

    public function createComponentDestinationForm(): DestinationForm
    {
        return $this->destinationFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $destination = $this->destinationRepository->getById($id);

        $this->template->destination = $destination;

        $this['destinationForm']['form']['id']->setDefaultValue($destination->getId());
        $this['destinationForm']['form']['name']->setDefaultValue($destination->getName());
        $this['destinationForm']['form']['destination_type_id']->setDefaultValue($destination->getDestinationTypeId());
        $this['destinationForm']['form']['nearby_city']->setDefaultValue($destination->getNearbyCity());
        $this['destinationForm']['form']['distance_from_home']->setDefaultValue($destination->getDistanceFromHome());
        $this['destinationForm']['form']['details']->setDefaultValue($destination->getDetails());
        $this['destinationForm']['form']['visited']->setDefaultValue($destination->getVisited());
    }

    public function renderCreate()
    {

    }
}