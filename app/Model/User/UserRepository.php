<?php
declare(strict_types=1);

namespace App\Model\User;

use App\Model\BaseRepository;

class UserRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'user';
    }

    public function getById(int $id): ?User
    {
        $row = $this->getDbConnection()->query('SELECT * FROM user WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $user = new User(
            (string)$row->name,
            (string)$row->email,
            (string)$row->password
        );
        $user->setId((int)$row->id);

        return $user;
    }

    public function getByEmail(string $email): ?User
    {
        $row = $this->getDbConnection()->query('SELECT * FROM user WHERE email = ?', $email)->fetch();

        if ($row === null) {
            return null;
        }

        $user = new User(
            (string)$row->name,
            (string)$row->email,
            (string)$row->password
        );
        $user->setId((int)$row->id);

        return $user;
    }

    /**
     * @return User[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM user')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $users = [];

        foreach ($rows as $row) {
            $user = new User(
                (string)$row->name,
                (string)$row->email,
                (string)$row->password
            );
            $user->setId((int)$row->id);

            $users[] = $user;
        }

        return $users;
    }
}