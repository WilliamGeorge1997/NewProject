<?php

namespace Modules\Common\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\DTO\CityDto;
use Modules\Common\Http\Requests\CityRequest;
use Modules\Common\Service\CityService;


class CityController extends Controller
{
    private $cityService;
    public function __construct(CityService $cityService)
    {
        $this->middleware(['auth:admin','prevent-back-history']);
        $this->cityService = $cityService;
        $this->middleware('permission:Index-city|Create-city|Edit-city|Delete-city', ['only' => ['index','store']]);
        $this->middleware('permission:Create-city', ['only' => ['create','store']]);
        $this->middleware('permission:Edit-city', ['only' => ['edit','update','activate']]);
        $this->middleware('permission:Delete-city', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $cities = $this->cityService->findAll();
        if($request->ajax()){
            return response()->json(['data' => $cities]);
        }
        return view('common::cities.index',['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('common::cities.create');
    }

    public function store(CityRequest $request)
    {
        $data = $request->except('_token');
        $data = (new CityDto($request))->dataFromRequest();
        $country = $this->cityService->save($data);
        return redirect('/admin/cities')->with('created','created');
    }

   

    public function edit($id)
    {
        $city = $this->cityService->findById($id);
        return view('common::cities.edit',compact('city'));
    }


    public function update(CityRequest $request, $id)
    {
        $data = $request->except('_token');
        $data = (new CityDto($request))->dataFromRequest();
        $this->cityService->update($id,$data);
        return redirect('admin/cities')->with('updated','updated');
    }

    public function destroy($id)
    {
        $this->cityService->delete($id);
        return response()->json(['data' => 'success'],200);
    }

    public function activate($id){
        $this->cityService->activate($id);
        return redirect('admin/cities')->with('updated','updated');
    }
}
