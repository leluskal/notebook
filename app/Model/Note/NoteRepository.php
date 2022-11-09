<?php
declare(strict_types=1);

namespace App\Model\Note;

use App\Model\BaseRepository;

class NoteRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'note';
    }

    public function getById(int $id): ?Note
    {
        $row = $this->getDbConnection()->query('SELECT * FROM note WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $note = new Note(
            (string)$row->text,
            (int)$row->quote,
            $row->created,
            (int)$row->year
        );
        $note->setId((int)$row->id);

        return $note;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $notes = [];

        foreach ($rows as $row) {
            $note = new Note(
                (string)$row->text,
                (int)$row->quote,
                $row->created,
                (int)$row->year
            );
            $note->setId((int)$row->id);

            $notes[] = $note;
        }

        return $notes;
    }

    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM note')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM note WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}