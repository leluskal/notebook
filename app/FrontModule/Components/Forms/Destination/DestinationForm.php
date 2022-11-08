<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Destination;

use App\Model\Destination\DestinationRepository;
use App\Model\DestinationType\DestinationTypeRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DestinationForm extends Control
{
    /**
     * @var DestinationTypeRepository
     */
    private $destinationTypeRepository;

    /**
     * @var DestinationRepository
     */
    private $destinationRepository;

    public function __construct(
        DestinationTypeRepository $destinationTypeRepository,
        DestinationRepository $destinationRepository
    )
    {
        $this->destinationTypeRepository = $destinationTypeRepository;
        $this->destinationRepository = $destinationRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Destination')
             ->setRequired('The name is required');

        $form->addSelect('destination_type_id', 'Destination Type', $this->destinationTypeRepository->findAllForSelectBox())
             ->setPrompt('--Choose destination type--')
             ->setRequired('The destination type is required');

        $form->addText('nearby_city', 'Nearby City')
             ->setRequired('The city is required');

        $form->addInteger('distance_from_home', 'Distance From Home')
             ->setRequired('The distance is required');

        $form->addTextArea('details', 'Details');

        $form->addCheckbox('visited', 'Visited?');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->destinationRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of destination is deleted', 'info');
            $this->getPresenter()->redirect('Destination:default');
        }

        if ($values->id === '') {
            $this->destinationRepository->create([
                'name' => $values->name,
                'destination_type_id' => $values->destination_type_id,
                'nearby_city' => $values->nearby_city,
                'distance_from_home' => $values->distance_from_home,
                'details' => $values->details !== '' ? $values->details : null,
                'visited' => $values->visited
            ]);
            $this->getPresenter()->flashMessage('The new record of destination is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
                'destination_type_id' => $values->destination_type_id,
                'nearby_city' => $values->nearby_city,
                'distance_from_home' => $values->distance_from_home,
                'details' => $values->details !== '' ? $values->details : null,
                'visited' => $values->visited
            ];

            $this->destinationRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of destination is updated', 'info');
        }

        $this->getPresenter()->redirect('Destination:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/destinationForm.latte');
        $template->render();
    }
}