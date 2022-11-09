<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\ApartmentList;

use App\Model\ApartmentList\ApartmentListRepository;

class ApartmentListFormFactory
{
    /**
     * @var ApartmentListRepository
     */
    private $apartmentListRepository;

    public function __construct(ApartmentListRepository $apartmentListRepository)
    {
        $this->apartmentListRepository = $apartmentListRepository;
    }

    public function create(): ApartmentListForm
    {
        return new ApartmentListForm($this->apartmentListRepository);
    }
}