<?php


namespace Modules\Service\ViewModel;

use Modules\Service\Service\ServiceService;

class SubServiceViewModel
{
    public function services(){
        return (new ServiceService())->active();
    }

}
