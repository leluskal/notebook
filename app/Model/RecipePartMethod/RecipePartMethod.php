<?php
declare(strict_types=1);

namespace App\Model\RecipePartMethod;

use App\Model\RecipePart\RecipePart;

class RecipePartMethod
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $recipePartId;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var string
     */
    private $method;

    /**
     * @var RecipePart
     */
    private $recipePart;

    public function __construct(int $recipePartId, int $sort, string $method)
    {
        $this->recipePartId = $recipePartId;
        $this->sort = $sort;
        $this->method = $method;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRecipePartId(): int
    {
        return $this->recipePartId;
    }

    public function setRecipePartId(int $recipePartId): void
    {
        $this->recipePartId = $recipePartId;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getRecipePart(): RecipePart
    {
        return $this->recipePart;
    }

    public function setRecipePart(RecipePart $recipePart): void
    {
        $this->recipePart = $recipePart;
    }
}