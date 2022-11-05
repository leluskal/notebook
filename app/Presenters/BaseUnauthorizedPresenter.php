<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BaseUnauthorizedPresenter extends Presenter
{
    public function startup()
    {
        parent::startup();

        if ($this->getUser()->isLoggedIn()) {
            $this->redirect('Homepage:default');
        }
    }
}