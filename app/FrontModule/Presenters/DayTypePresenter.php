<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\DayType\DayTypeForm;
use App\FrontModule\Components\Forms\DayType\DayTypeFormFactory;
use App\Model\DayType\DayTypeRepository;

class DayTypePresenter extends BasePresenter
{
    /**
     * @var DayTypeRepository
     */
    private $dayTypeRepository;

    /**
     * @var DayTypeFormFactory
     */
    private $dayTypeFormFactory;

    public function __construct(DayTypeRepository $dayTypeRepository, DayTypeFormFactory $dayTypeFormFactory)
    {
        $this->dayTypeRepository = $dayTypeRepository;
        $this->dayTypeFormFactory = $dayTypeFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutPlanning');
    }

    public function createComponentDayTypeForm(): DayTypeForm
    {
        return $this->dayTypeFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $dayType = $this->dayTypeRepository->getById($id);

        $this['dayTypeForm']['form']['id']->setDefaultValue($dayType->getId());
        $this['dayTypeForm']['form']['name']->setDefaultValue($dayType->getName());
        $this['dayTypeForm']['form']['work_day']->setDefaultValue($dayType->getWorkDay());
        $this['dayTypeForm']['form']['created']->setDefaultValue($dayType->getCreated()->format('Y-m-d'));
        $this['dayTypeForm']['form']['year']->setDefaultValue($dayType->getYear());
    }

    public function renderCreate(int $year)
    {
        $this['dayTypeForm']['form']['year']->setDefaultValue($year);
    }
}