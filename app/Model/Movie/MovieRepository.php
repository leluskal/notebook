<?php
declare(strict_types=1);

namespace App\Model\Movie;

use App\Model\BaseRepository;

class MovieRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'movie';
    }

    public function getById(int $id): ?Movie
    {
        $row = $this->getDbConnection()->query('SELECT * FROM movie WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $movie = new Movie(
            (string)$row->name,
            (string)$row->country_of_origin,
            (int)$row->release_year
        );
        $movie->setId((int)$row->id);
        $movie->setRating($row->rating);

        return $movie;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $movies = [];

        foreach ($rows as $row) {
            $movie = new Movie(
                (string)$row->name,
                (string)$row->country_of_origin,
                (int)$row->release_year
            );
            $movie->setId((int)$row->id);
            $movie->setRating($row->rating);

            $movies[] = $movie;
        }

        return $movies;
    }

    /**
     * @return Movie[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM movie')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $movies = $this->findAll();

        $returnArray = [];

        foreach ($movies as $movie) {
            $returnArray[$movie->getId()] = $movie->getName();
        }

        return $returnArray;
    }
}