<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\FurnishingLink;

use App\Model\Furnishing\FurnishingRepository;
use App\Model\FurnishingLink\FurnishingLinkRepository;
use App\Model\Room\RoomRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class FurnishingLinkForm extends Control
{
    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * @var FurnishingLinkRepository
     */
    private $furnishingLinkRepository;

    public function __construct(
        FurnishingRepository $furnishingRepository,
        RoomRepository $roomRepository,
        FurnishingLinkRepository $furnishingLinkRepository
    )
    {
        $this->furnishingRepository = $furnishingRepository;
        $this->roomRepository = $roomRepository;
        $this->furnishingLinkRepository = $furnishingLinkRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('furnishing_id', 'Furnishing', $this->furnishingRepository->findAllForSelectBox());

        $form->addText('link', 'Link')
             ->setRequired('The link is required');

        $form->addText('link_name', 'Link Name')
             ->setRequired('The link name is required');

        $form->addText('shop', 'Shop')
             ->setRequired('The shop is required');

        $form->addInteger('price', 'Price')
             ->setRequired('The price is required');

        $form->addSelect('room_id', 'Room', $this->roomRepository->findAllForSelectBox())
             ->setPrompt('--Choose room--')
             ->setRequired('The room is required');

        $form->addCheckbox('purchased', 'Purchased');

        $form->addText('date_of_purchase', 'Date Of Purchase')
             ->setHtmlType('date');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
            ->setValidationScope([$form['id'], $form['furnishing_id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->furnishingLinkRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The link is deleted', 'info');
            $this->getPresenter()->redirect('Furnishing:detail', ['furnishingId'=> $values->furnishing_id]);
        }

        if ($values->id === '') {
            $this->furnishingLinkRepository->create([
                'furnishing_id' => $values->furnishing_id,
                'link' => $values->link,
                'link_name' => $values->link_name,
                'shop' => $values->shop,
                'price' => $values->price,
                'room_id' => $values->room_id,
                'purchased' => $values->purchased,
                'date_of_purchase' => $values->date_of_purchase !== '' ? $values->date_of_purchase : null
            ]);
            $this->getPresenter()->flashMessage('The new link is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'furnishing_id' => $values->furnishing_id,
                'link' => $values->link,
                'link_name' => $values->link_name,
                'shop' => $values->shop,
                'price' => $values->price,
                'room_id' => $values->room_id,
                'purchased' => $values->purchased,
                'date_of_purchase' => $values->date_of_purchase !== '' ? $values->date_of_purchase : null
            ];

            $this->furnishingLinkRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The link is updated', 'info');
        }

        $this->getPresenter()->redirect('Furnishing:detail', ['furnishingId'=> $values->furnishing_id]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/furnishingLinkForm.latte');
        $template->render();
    }
}