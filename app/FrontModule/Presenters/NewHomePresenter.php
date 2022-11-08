<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

class NewHomePresenter extends BasePresenter
{
    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutNewHome');
    }
}