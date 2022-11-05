<?php
declare(strict_types=1);

namespace App\Model\FitnessInstructor;

use App\Model\BaseRepository;

class FitnessInstructorRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'fitness_instructor';
    }

    public function getById(int $id): ?FitnessInstructor
    {
        $row = $this->getDbConnection()->query('SELECT * FROM fitness_instructor WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $fitnessInstructor = new FitnessInstructor(
            (string)$row->name
        );
        $fitnessInstructor->setId((int)$row->id);

        return $fitnessInstructor;
    }

    /**
     * @return FitnessInstructor[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM fitness_instructor')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $fitnessInstructors = $this->findAll();

        $returnArray = [];

        foreach ($fitnessInstructors as $instructor) {
            $returnArray[$instructor->getId()] = $instructor->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $fitnessInstructors = [];

        foreach ($rows as $row) {
            $fitnessInstructor = new FitnessInstructor(
                (string)$row->name
            );
            $fitnessInstructor->setId((int)$row->id);

            $fitnessInstructors[] = $fitnessInstructor;
        }

        return $fitnessInstructors;
    }
}