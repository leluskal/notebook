<?php
declare(strict_types=1);

namespace App\Model\Genre;

use App\Model\BaseRepository;

class GenreRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'genre';
    }

    public function getById(int $id): ?Genre
    {
        $row = $this->getDbConnection()->query('SELECT * FROM genre WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $genre = new Genre(
            (string)$row->name
        );
        $genre->setId((int)$row->id);

        return $genre;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $genres = [];

        foreach ($rows as $row) {
            $genre = new Genre(
                (string)$row->name
            );
            $genre->setId((int)$row->id);

            $genres[] = $genre;
        }

        return $genres;
    }

    /**
     * @return Genre[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM genre')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $genres = $this->findAll();

        $returnArray= [];

        foreach ($genres as $genre) {
            $returnArray[$genre->getId()] = $genre->getName();
        }

        return $returnArray;
    }
}