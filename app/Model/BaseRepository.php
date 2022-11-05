<?php
declare(strict_types=1);

namespace App\Model;

use Dibi\Connection;

abstract class BaseRepository
{
    /**
     * @var DibiConnection
     */
    protected $dibiConnection;

    public function __construct(DibiConnection $dibiConnection)
    {
        $this->dibiConnection = $dibiConnection;
    }

    public function getDbConnection(): Connection
    {
        return $this->dibiConnection->getConnection();
    }

    abstract public function getTableName(): string;

    abstract public function getById(int $id);

    public function create(array $data)
    {
        try {
            $this->getDbConnection()->query(
                'INSERT INTO ' . $this->getTableName(),
                $data
            );
        } catch (\Exception $e) {
            bdump($e->getMessage());
        }

        $lastInsertedId = $this->getDbConnection()
            ->query('SELECT id FROM ' . $this->getTableName() . ' ORDER BY id DESC LIMIT 1')
            ->fetchSingle();

        if ($lastInsertedId === null) {
            return null;
        }

        $lastInsertedId = (int) $lastInsertedId;

        return $this->getById($lastInsertedId);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws \Dibi\Exception
     */
    public function updateById(int $id, array $data)
    {
        $this->getDbConnection()->query(
            'UPDATE ' . $this->getTableName() . ' SET',
            $data,
            'WHERE id = ?',
            $id
        );

        return $this->getById($id);
    }

    public function deleteById(int $id): void
    {
        $this->getDbConnection()->query(
            'DELETE FROM ' . $this->getTableName(),
            'WHERE id = ?',
            $id
        );
    }
}