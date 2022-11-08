<?php
declare(strict_types=1);

namespace App\Model\Recipe;

class Recipe
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
    private $newRecipe;

    /**
     * @var int
     */
    private $recipeCategoryId;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var int|null
     */
    private $rating;

    /**
     * @var string|null
     */
    private $imagePath;

    public function __construct(string $name, int $newRecipe, int $recipeCategoryId)
    {
        $this->name = $name;
        $this->newRecipe = $newRecipe;
        $this->recipeCategoryId = $recipeCategoryId;
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

    public function getNewRecipe(): int
    {
        return $this->newRecipe;
    }

    public function setNewRecipe(int $newRecipe): void
    {
        $this->newRecipe = $newRecipe;
    }

    public function getRecipeCategoryId(): int
    {
        return $this->recipeCategoryId;
    }

    public function setRecipeCategoryId(int $recipeCategoryId): void
    {
        $this->recipeCategoryId = $recipeCategoryId;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }
}