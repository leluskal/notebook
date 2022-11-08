<?php
declare(strict_types=1);

namespace App\Model\FurnishingExpense;

class FurnishingExpense
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $furnishings;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string|null
     */
    private $note;

    public function __construct(string $furnishings, int $price)
    {
        $this->furnishings = $furnishings;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFurnishings(): string
    {
        return $this->furnishings;
    }

    public function setFurnishings(string $furnishings): void
    {
        $this->furnishings = $furnishings;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }
}