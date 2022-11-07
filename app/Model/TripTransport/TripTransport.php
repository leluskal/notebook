<?php
declare(strict_types=1);

namespace App\Model\TripTransport;

class TripTransport
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $tripId;

    /**
     * @var int
     */
    private $transportTypeId;

    public function __construct(int $tripId, int $transportTypeId)
    {
        $this->tripId = $tripId;
        $this->transportTypeId = $transportTypeId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTripId(): int
    {
        return $this->tripId;
    }

    public function setTripId(int $tripId): void
    {
        $this->tripId = $tripId;
    }

    public function getTransportTypeId(): int
    {
        return $this->transportTypeId;
    }

    public function setTransportTypeId(int $transportTypeId): void
    {
        $this->transportTypeId = $transportTypeId;
    }
}