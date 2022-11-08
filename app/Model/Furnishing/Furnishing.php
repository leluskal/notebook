<?php
declare(strict_types=1);

namespace App\Model\Furnishing;

class Furnishing
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $furnishingCategoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $note;

    public function __construct(int $furnishingCategoryId, string $name)
    {
        $this->furnishingCategoryId = $furnishingCategoryId;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFurnishingCategoryId(): int
    {
        return $this->furnishingCategoryId;
    }

    public function setFurnishingCategoryId(int $furnishingCategoryId): void
    {
        $this->furnishingCategoryId = $furnishingCategoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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