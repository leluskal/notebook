<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Trip\TripForm;
use App\FrontModule\Components\Forms\Trip\TripFormFactory;
use App\Model\TransportType\TransportTypeRepository;
use App\Model\Trip\TripRepository;
use App\Model\Trip\TripService;
use App\Model\TripTransport\TripTransportRepository;

class TripPresenter extends BasePresenter
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * @var TripFormFactory
     */
    private $tripFormFactory;

    /**
     * @var TripTransportRepository
     */
    private $tripTransportRepository;

    /**
     * @var TripService
     */
    private $tripService;

    public function __construct(
        TripRepository $tripRepository,
        TripFormFactory $tripFormFactory,
        TripTransportRepository $tripTransportRepository,
        TripService $tripService
    )
    {
        $this->tripRepository = $tripRepository;
        $this->tripFormFactory = $tripFormFactory;
        $this->tripTransportRepository = $tripTransportRepository;
        $this->tripService = $tripService;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }

    public function renderDefault($month = null)
    {
        $this->template->months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $tripsByMonth = $this->tripRepository->findAllGroupedByMonth((int) $this->year, (string) $month);
        $this->template->tripsByMonth = $this->tripService->fillTransportTypeIds($tripsByMonth);

        $this->template->year = $this->year;
    }

    public function createComponentTripForm(): TripForm
    {
        return $this->tripFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $trip = $this->tripRepository->getById($id);

        $this->template->trip = $trip;

        $this['tripForm']['form']['id']->setDefaultValue($trip->getId());
        $this['tripForm']['form']['month']->setDefaultValue($trip->getMonth());
        $this['tripForm']['form']['date']->setDefaultValue($trip->getDate()->format('Y-m-d'));
        $this['tripForm']['form']['destination']->setDefaultValue($trip->getDestination());
        $this['tripForm']['form']['start_of_trip']->setDefaultValue($trip->getStartOfTrip()->format('%H:%I'));
        $this['tripForm']['form']['end_of_trip']->setDefaultValue($trip->getEndOfTrip()->format('%H:%I'));
        $this['tripForm']['form']['year']->setDefaultValue($trip->getYear());
        $this['tripForm']['form']['details']->setDefaultValue($trip->getDetails());
        $this['tripForm']['form']['rating']->setDefaultValue($trip->getRating());
        $transportIds = $this->tripTransportRepository->getAllTransportIdsByTripId($trip->getId());
        $this['tripForm']['form']['transport_ids']->setDefaultValue($transportIds);
    }

    public function renderCreate(int $year)
    {
        $this['tripForm']['form']['year']->setDefaultValue($year);

    }
}