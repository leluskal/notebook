<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\DailyMobile;

use App\Model\DailyMobile\DailyMobileRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DailyMobileForm extends Control
{
    /**
     * @var DailyMobileRepository
     */
    private $dailyMobileRepository;

    public function __construct(DailyMobileRepository $dailyMobileRepository)
    {
        $this->dailyMobileRepository = $dailyMobileRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('day_type', 'Free Day/Work')
            ->setRequired('The day type is required');

        $form->addInteger('screen_usage_time', 'Screen Usage Time')
             ->setRequired('The integer is required');

        $form->addInteger('number_of_screen_unlocks', 'Number Of Screen Unlocks')
             ->setRequired('The integer is required');

        $form->addInteger('non_interactive_mode_time', 'Non Interactive Mode Time');

        $form->addInteger('reading_time', 'Reading Time');

        $form->addInteger('playing_time', 'Playing Time');

        $form->addInteger('insta_time', 'Instagram Time');

        $form->addHidden('day_number');

        $form->addHidden('month');

        $form->addHidden('year');

        $form->addTextArea('note', 'Note');

        $form->addText('created', 'Created')
             ->setHtmlType('date')
             ->setRequired('The created is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->dailyMobileRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record of mobile is deleted', 'info');
            $this->getPresenter()->redirect('DailyMobile:default');
        }

        if ($values->id === '') {
            $this->dailyMobileRepository->create([
                'day_type' => $values->day_type,
                'screen_usage_time' => $values->screen_usage_time,
                'number_of_screen_unlocks' => $values->number_of_screen_unlocks,
                'non_interactive_mode_time' => $values->non_interactive_mode_time !== '' ? $values->non_interactive_mode_time : null,
                'reading_time' => $values->reading_time !== '' ? $values->reading_time : null,
                'playing_time' => $values->playing_time !== '' ? $values->playing_time : null,
                'insta_time' => $values->insta_time !== '' ? $values->insta_time : null,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'note' => $values->note !== '' ? $values->note : null,
                'created' => $values->created
            ]);
            $this->getPresenter()->flashMessage('The new record of mobile is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'day_type' => $values->day_type,
                'screen_usage_time' => $values->screen_usage_time,
                'number_of_screen_unlocks' => $values->number_of_screen_unlocks,
                'non_interactive_mode_time' => $values->non_interactive_mode_time !== '' ? $values->non_interactive_mode_time : null,
                'reading_time' => $values->reading_time !== '' ? $values->reading_time : null,
                'playing_time' => $values->playing_time !== '' ? $values->playing_time : null,
                'insta_time' => $values->insta_time !== '' ? $values->insta_time : null,
                'day_number' => $values->day_number,
                'month' => $values->month,
                'year' => $values->year,
                'note' => $values->note !== '' ? $values->note : null,
                'created' => $values->created
            ];

            $this->dailyMobileRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record of mobile is updated', 'info');
        }

        $this->getPresenter()->redirect('DailyMobile:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/dailyMobileForm.latte');
        $template->render();
    }
}