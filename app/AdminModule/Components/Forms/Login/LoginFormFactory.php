<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Login;

use App\Model\Authentication\UserAuthenticator;
use App\Model\User\UserRepository;
use Nette\Security\User;

class LoginFormFactory
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserAuthenticator
     */
    private $userAuthenticator;

    /**
     * @var User
     */
    private $securityUser;

    public function __construct(UserRepository $userRepository, UserAuthenticator $userAuthenticator, User $securityUser)
    {
        $this->userRepository = $userRepository;
        $this->userAuthenticator = $userAuthenticator;
        $this->securityUser = $securityUser;
    }

    public function create(): LoginForm
    {
        return new LoginForm($this->userRepository, $this->userAuthenticator, $this->securityUser);
    }
}