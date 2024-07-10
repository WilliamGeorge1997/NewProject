<?php

namespace Modules\Category\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Service\CategoryService;


class CategoryController extends Controller
{

    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        // $this->middleware(['auth:client']);
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->active();
        return return_msg(true, 'Active Categories', $categories);
    }

}
