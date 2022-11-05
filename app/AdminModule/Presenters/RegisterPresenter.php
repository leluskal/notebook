<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Register\RegisterFormFactory;
use App\AdminModule\Components\Forms\Register\RegisterForm;
use App\Presenters\BaseUnauthorizedPresenter;

class RegisterPresenter extends BaseUnauthorizedPresenter
{
    /**
     * @var RegisterFormFactory
     */
    private $registerFormFactory;

    public function __construct(RegisterFormFactory $registerFormFactory)
    {
        $this->registerFormFactory = $registerFormFactory;
    }

    public function createComponentRegisterForm(): RegisterForm
    {
        return $this->registerFormFactory->create();
    }
}