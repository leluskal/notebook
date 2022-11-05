<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

abstract class BasePresenter extends Presenter
{
    /**
     * @var string
     */
    public $year;

    /**
     * @persistent
     * @var string
     */
    public $month;

    public function beforeRender()
    {
        parent::beforeRender();

        if ($this->year === null) {
            $this->year = DateTime::from('now')->format('Y');
        }

        if ($this->month === null) {
            $this->month = DateTime::from('now')->format('n');
        }

        $this->template->actualMonth = $this->month;
    }

    public function startup()
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect(':Admin:Login:default');
        }
    }

    public function handleLogout()
    {
        $this->getUser()->logout(true);

        $this->flashMessage('You are successfully logout', 'success');
        $this->redirect(':Admin:Login:default');
    }

    public function createComponentYearForm(): Form
    {
        $form = new Form();

        $form->addSelect('year', 'Year', [2022 => 2022, 2023 => 2023]);

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'yearFormSuccess'];

        return $form;
    }

    public function yearFormSuccess(Form $form, ArrayHash $values)
    {
        $this->year = $values->year;

        $this->flashMessage('The year has been set', 'success');
        $this->redirect('this');
    }
}