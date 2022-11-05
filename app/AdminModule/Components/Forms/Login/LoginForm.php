<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Login;

use App\Model\Authentication\UserAuthenticator;
use App\Model\User\UserRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class LoginForm extends Control
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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addEmail('email', 'Email')
            ->setRequired('The email is required');

        $form->addPassword('password', 'Password')
            ->setRequired('The password is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $user = $this->userRepository->getByEmail($values->email);

        if ($user === null) {
            $this->getPresenter()->flashMessage('User not found or incorrect password', 'danger');
            $this->redirect('this');
        }

        try {
            $userIdentity = $this->userAuthenticator->authenticate($values->email, $values->password);
            $this->securityUser->login($userIdentity);
        } catch (AuthenticationException $e) {
            $this->getPresenter()->flashMessage('User not found or incorrect password', 'danger');
            $this->redirect('this');
        }

        $this->getPresenter()->flashMessage('You have been logged in successfully.', 'success');
        $this->getPresenter()->redirect(':Front:Introduction:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/loginForm.latte');
        $template->render();
    }
}