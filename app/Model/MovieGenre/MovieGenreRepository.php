<?php
declare(strict_types=1);

namespace App\Model\MovieGenre;

use App\Model\BaseRepository;

class MovieGenreRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'movie_genre';
    }

    public function getById(int $id): ?MovieGenre
    {
        $row = $this->getDbConnection()->query('SELECT * FROM movie_genre WHERE id = ?', $id)->fetch();

        if ($row === null) {
          return null;
        }

        $movieGenre = new MovieGenre(
            (int)$row->movie_id,
            (int)$row->genre_id
        );
        $movieGenre->setId((int)$row->id);

        return $movieGenre;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $movieGenres = [];

        foreach ($rows AS $row) {
            $movieGenre = new MovieGenre(
                (int)$row->movie_id,
                (int)$row->genre_id
            );
            $movieGenre->setId((int)$row->id);
        }

        return $movieGenres;
    }

    public function deleteAllByMovieId(int $movieId): void
    {
        $this->getDbConnection()->query('DELETE FROM movie_genre WHERE movie_id  = ?', $movieId);
    }

    public function getAllGenreIdsByMovieId(int $movieId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT genre_id FROM movie_genre WHERE movie_id = ?', $movieId)
            ->fetchAll();

        $returnArray = [];

        foreach ($rows as $row) {
           $returnArray[] =  $row->genre_id;
        }

        return $returnArray;
    }
}