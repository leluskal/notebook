<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Login\LoginForm;
use App\AdminModule\Components\Forms\Login\LoginFormFactory;
use App\Presenters\BaseUnauthorizedPresenter;

class LoginPresenter extends BaseUnauthorizedPresenter
{
    /**
     * @var LoginFormFactory
     */
    private $loginFormFactory;

    public function __construct(LoginFormFactory $loginFormFactory)
    {
        $this->loginFormFactory = $loginFormFactory;
    }

    public function createComponentLoginForm(): LoginForm
    {
        return $this->loginFormFactory->create();
    }
}