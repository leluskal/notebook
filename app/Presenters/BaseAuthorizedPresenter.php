<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BaseAuthorizedPresenter extends Presenter
{
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
}