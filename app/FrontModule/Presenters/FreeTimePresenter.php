<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

class FreeTimePresenter extends BasePresenter
{
    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutFreeTime');
    }
}