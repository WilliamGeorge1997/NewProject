<?php


namespace Modules\Service\ViewModel;

use Modules\Category\Service\CategoryService;

class ServiceViewModel
{
    public function categories(){
        return (new CategoryService())->active();
    }

}
