<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\DTO\CategoryDto;
use Modules\Category\Entities\Category;
use Modules\Category\Service\CategoryService;
use Modules\Category\Validation\CategoryValidation;
use Modules\Category\ViewModel\CategoryViewModel;
use Modules\Common\Helper\UploaderHelper;
use Modules\Country\Service\CityService;
use Spatie\Activitylog\Models\Activity;

class CategoryController extends Controller
{
    use UploaderHelper,CategoryValidation;
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware(['auth:admin','prevent-back-history']);
        $this->categoryService = $categoryService;
        $this->middleware('permission:Index-category|Create-category|Edit-category|Delete-category', ['only' => ['index','store']]);
        $this->middleware('permission:Create-category', ['only' => ['create','store']]);
        $this->middleware('permission:Edit-category', ['only' => ['edit','update','activate']]);
        $this->middleware('permission:Delete-category', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {


        $categories = $this->categoryService->findAll();
        if($request->ajax()){
            return response()->json(['data' => $categories->items()]);
        }
        return view('category::categories.index',['categories' => $categories,'request' => $request]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new CategoryViewModel;
        return view('category::categories.create',compact('viewModel'));
    }


    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validation = $this->validateStore($data);
        if ($validation->fails()) return redirect()->back()->withInput()->withErrors($validation);
        $data = (new CategoryDto($request))->dataFromRequest();
        $category = $this->categoryService->save($data);
        return redirect('/admin/categories')->with('created','created');
    }

    public function edit($id)
    {
        $category = $this->categoryService->findById($id);
        $viewModel = new CategoryViewModel;
        return view('category::categories.edit',compact('category','viewModel'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validation = $this->validateUpdate($data);
        if ($validation->fails()) return redirect()->back()->withErrors($validation);
        $data = (new CategoryDto($request))->dataFromRequest();
        $this->categoryService->update($id,$data);
        return redirect('admin/categories')->with('updated','updated');
    }

    public function destroy($id,Request $request)
    {
        $this->categoryService->delete($id);
        return response()->json(['data' => 'success'],200);
    }

    public function activate($id){
        $this->categoryService->activate($id);
        return redirect('admin/categories')->with('updated','updated');
    }


    public function ajax_categoryOne(Request $request)
    {
        $category =  (new CategoryService())->findById($request->id);
        $categoryData=  (new CategoryService())->findBy('category_id', $category->id);

        if(count($categoryData)!=0)
        return view('category::categories.ajax_category', ['categoryData' => $categoryData]);

    }



}
