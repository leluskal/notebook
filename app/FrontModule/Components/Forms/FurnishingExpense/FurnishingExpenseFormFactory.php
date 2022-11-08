<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\FurnishingExpense;

use App\Model\FurnishingExpense\FurnishingExpenseRepository;

class FurnishingExpenseFormFactory
{
    /**
     * @var FurnishingExpenseRepository
     */
    private $furnishingExpenseRepository;

    public function __construct(FurnishingExpenseRepository $furnishingExpenseRepository)
    {
        $this->furnishingExpenseRepository = $furnishingExpenseRepository;
    }

    public function create(): FurnishingExpenseForm
    {
        return new FurnishingExpenseForm($this->furnishingExpenseRepository);
    }
}