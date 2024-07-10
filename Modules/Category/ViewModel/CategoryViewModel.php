<?php


namespace Modules\Category\ViewModel;

use Modules\Category\Service\CategoryService;

class CategoryViewModel
{
    public function categories(){
        return (new CategoryService())->active();
    }


    public function categoriesSelect()
    {
        return (new CategoryService())->MainCategory();
    }
}
