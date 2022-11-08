<?php
declare(strict_types=1);

namespace App\Model\Destination;

use App\Model\DestinationType\DestinationType;

class Destination
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $destinationTypeId;

    /**
     * @var string
     */
    private $nearbyCity;

    /**
     * @var int
     */
    private $distanceFromHome;

    /**
     * @var string|null
     */
    private $details;

    /**
     * @var int
     */
    private $visited;

    /**
     * @var DestinationType
     */
    private $destinationType;

    public function __construct(
        string $name,
        int $destinationTypeId,
        string $nearbyCity,
        int $distanceFromHome,
        int $visited
    )
    {
        $this->name = $name;
        $this->destinationTypeId = $destinationTypeId;
        $this->nearbyCity = $nearbyCity;
        $this->distanceFromHome = $distanceFromHome;
        $this->visited = $visited;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDestinationTypeId(): int
    {
        return $this->destinationTypeId;
    }

    public function setDestinationTypeId(int $destinationTypeId): void
    {
        $this->destinationTypeId = $destinationTypeId;
    }

    public function getNearbyCity(): string
    {
        return $this->nearbyCity;
    }

    public function setNearbyCity(string $nearbyCity): void
    {
        $this->nearbyCity = $nearbyCity;
    }

    public function getDistanceFromHome(): int
    {
        return $this->distanceFromHome;
    }

    public function setDistanceFromHome(int $distanceFromHome): void
    {
        $this->distanceFromHome = $distanceFromHome;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): void
    {
        $this->details = $details;
    }

    public function getVisited(): int
    {
        return $this->visited;
    }

    public function setVisited(int $visited): void
    {
        $this->visited = $visited;
    }

    public function getDestinationType(): DestinationType
    {
        return $this->destinationType;
    }

    public function setDestinationType(DestinationType $destinationType): void
    {
        $this->destinationType = $destinationType;
    }
}