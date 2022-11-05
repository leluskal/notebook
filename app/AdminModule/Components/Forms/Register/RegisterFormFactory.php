<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Register;

use App\Model\User\UserRepository;

class RegisterFormFactory
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(): RegisterForm
    {
        return new RegisterForm($this->userRepository);
    }
}