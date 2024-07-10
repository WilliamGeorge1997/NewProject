<?php

namespace Modules\Common\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\DTO\CityDto;
use Modules\Common\DTO\SliderDto;
use Modules\Common\Http\Requests\CityRequest;
use Modules\Common\Http\Requests\SliderRequest;
use Modules\Common\Service\SliderService;

class SliderController extends Controller
{
    private $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->middleware(['auth:admin','prevent-back-history']);
        $this->sliderService = $sliderService;
        $this->middleware('permission:Index-slider|Create-slider|Edit-slider|Delete-slider', ['only' => ['index','store']]);
        $this->middleware('permission:Create-slider', ['only' => ['create','store']]);
        $this->middleware('permission:Edit-slider', ['only' => ['edit','update','activate']]);
        $this->middleware('permission:Delete-slider', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $sliders = $this->sliderService->findAll();
        if($request->ajax()){
            return response()->json(['data' => $sliders]);
        }
        return view('common::sliders.index',['sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('common::sliders.create');
    }

    public function store(SliderRequest $request)
    {
        $data = $request->except('_token');
        $data = (new SliderDto($request))->dataFromRequest();
        $slider = $this->sliderService->save($data);
        return redirect('/admin/sliders')->with('created','created');
    }

   

    public function edit($id)
    {
        $slider = $this->sliderService->findById($id);
        return view('common::sliders.edit',compact('slider'));
    }


    public function update(SliderRequest $request, $id)
    {
        $data = $request->except('_token');
        $data = (new SliderDto($request))->dataFromRequest();
        $this->sliderService->update($id,$data);
        return redirect('admin/sliders')->with('updated','updated');
    }

    public function destroy($id)
    {
        $this->sliderService->delete($id);
        return response()->json(['data' => 'success'],200);
    }

    public function activate($id){
        $this->sliderService->activate($id);
        return redirect('admin/sliders')->with('updated','updated');
    }
}
