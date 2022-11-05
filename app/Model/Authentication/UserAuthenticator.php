<?php
declare(strict_types=1);

namespace App\Model\Authentication;

use App\Model\User\UserRepository;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;

class UserAuthenticator implements Authenticator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $user, string $password): IIdentity
    {
        $userEntity = $this->userRepository->getByEmail($user);

        if ($userEntity === null) {
            throw new AuthenticationException('User not found');
        }

        if (password_verify($password, $userEntity->getPassword()) === false) {
            throw new AuthenticationException('Incorrect password');
        }

        return new UserIdentity($userEntity->getId(), $userEntity->getPassword());
    }

}