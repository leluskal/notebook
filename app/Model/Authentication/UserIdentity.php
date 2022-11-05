<?php
declare(strict_types=1);

namespace App\Model\Authentication;

use Nette\Security\IIdentity;

class UserIdentity implements IIdentity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    public function __construct(int $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return [
            'admin'
        ];
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}