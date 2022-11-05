<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Register;

use App\Model\User\UserRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RegisterForm extends Control
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Name')
            ->setRequired('The name is required');

        $form->addEmail('email', 'Email')
            ->setRequired('The email is required');

        $passwordInput = $form->addPassword('password', 'Password')
            ->setRequired('The password is required');

        $form->addPassword('password_confirm', 'Password')
            ->setRequired('The password is required')
            ->addRule(Form::EQUAL, 'The passwords are not equal', $passwordInput);

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->password !== $values->password_confirm) {
            $this->getPresenter()->flashMessage('Passwords are not equal', 'danger');
            $this->getPresenter()->redirect('this');
        }

        $this->userRepository->create([
            'name' => $values->name,
            'email' => $values->email,
            'password' => password_hash($values->password, PASSWORD_BCRYPT)
        ]);

        $this->getPresenter()->flashMessage('The user is saved', 'success');
        $this->getPresenter()->redirect('Homepage:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/registerForm.latte');
        $template->render();
    }
}