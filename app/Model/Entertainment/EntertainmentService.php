<?php
declare(strict_types=1);

namespace App\Model\Entertainment;

use App\Model\EntertainmentType\EntertainmentTypeRepository;

class EntertainmentService
{
    /**
     * @var EntertainmentTypeRepository
     */
    private $entertainmentTypeRepository;

    /**
     * @var EntertainmentRepository
     */
    private $entertainmentRepository;

    public function __construct(
        EntertainmentTypeRepository $entertainmentTypeRepository,
        EntertainmentRepository $entertainmentRepository
    )
    {
        $this->entertainmentTypeRepository = $entertainmentTypeRepository;
        $this->entertainmentRepository = $entertainmentRepository;
    }

    public function mapEntity(Entertainment $entertainment): Entertainment
    {
        $entertainmentType = $this->entertainmentTypeRepository->getById($entertainment->getEntertainmentTypeId());

        $entertainment->setEntertainmentType($entertainmentType);

        return $entertainment;
    }

    public function mapEntityToArray(array $entertainments): array
    {
        $mappedEntities = [];

        foreach ($entertainments as $entertainment) {
            $mappedEntities[] = $this->mapEntity($entertainment);
        }

        return $mappedEntities;
    }

    public function findAllGroupedByMonth(int $year, string $month): array
    {
        $entertainments = $this->entertainmentRepository->findAllByYearAndMonth($year, $month);
        $entertainments = $this->mapEntityToArray($entertainments);

        $returnArray = [];

        foreach ($entertainments as $entertainment) {
            $returnArray[$entertainment->getMonth()][] = $entertainment;
        }

        return $returnArray;
    }

}