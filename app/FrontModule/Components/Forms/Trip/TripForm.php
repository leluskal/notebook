<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Trip;

use App\Model\Destination\DestinationRepository;
use App\Model\TransportType\TransportTypeRepository;
use App\Model\Trip\TripRepository;
use App\Model\TripTransport\TripTransportRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class TripForm extends Control
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * @var TransportTypeRepository
     */
    private $transportTypeRepository;

    /**
     * @var TripTransportRepository
     */
    private $tripTransportRepository;

    public function __construct(
        TripRepository $tripRepository,
        TransportTypeRepository $transportTypeRepository,
        TripTransportRepository $tripTransportRepository
    )
    {
        $this->tripRepository = $tripRepository;
        $this->transportTypeRepository = $transportTypeRepository;
        $this->tripTransportRepository = $tripTransportRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('month', 'Month')
             ->setRequired('The month is required');

        $form->addText('date', 'Date')
            ->setHtmlType('date')
            ->setRequired('The date is required');

        $form->addText('destination', 'Destination')
            ->setRequired('The destination is required');

        $form->addText('start_of_trip', 'Start Of The Trip')
            ->setHtmlType('time');

        $form->addText('end_of_trip', 'End Of The Trip')
            ->setHtmlType('time');

        $form->addMultiSelect('transport_ids', 'Transport', $this->transportTypeRepository->findAllForSelectBox());

        $form->addHidden('year');

        $form->addTextArea('details', 'Details')
             ->setRequired('The details are required');

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
            ->setPrompt('--Choose stars--');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->tripRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of trip is deleted', 'info');
            $this->getPresenter()->redirect('Trip:default', ['month' => $values->month]);
        }

        if ($values->id === '') {
            $trip = $this->tripRepository->create([
                'date' => $values->date,
                'month' => $values->month,
                'destination' => $values->destination,
                'start_of_trip' => $values->start_of_trip,
                'end_of_trip' => $values->end_of_trip,
                'year' => $values->year,
                'details' => $values->details,
                'rating' => $values->rating
            ]);

            foreach ($values->transport_ids as $transportId) {
                $this->tripTransportRepository->create([
                    'trip_id' => $trip->getId(),
                    'transport_type_id' => $transportId
                ]);
            }

            $this->getPresenter()->flashMessage('The new record of trip is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'date' => $values->date,
                'month' => $values->month,
                'destination' => $values->destination,
                'start_of_trip' => $values->start_of_trip,
                'end_of_trip' => $values->end_of_trip,
                'year' => $values->year,
                'details' => $values->details,
                'rating' => $values->rating
            ];

            $this->tripTransportRepository->deleteAllByTripId((int) $values->id);

            foreach ($values->transport_ids as $transportId) {
                $this->tripTransportRepository->create([
                    'trip_id' => $values->id,
                    'transport_type_id' => $transportId
                ]);
            }

            $this->tripRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of trip is updated', 'info');
        }

        $this->getPresenter()->redirect('Trip:default', ['month' => $values->month]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/tripForm.latte');
        $template->render();
    }
}