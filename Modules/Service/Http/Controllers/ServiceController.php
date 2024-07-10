<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Common\Http\Requests\IntroRequest;
use Modules\Common\Service\IntroService;
use Modules\Country\DTO\CountryDto;
use Modules\Country\Http\Requests\CountryRequest;
use Modules\Country\Service\CountryService;
use Modules\Service\Http\Requests\ServiceRequest;
use Modules\Service\Service\ServiceService;
use Modules\Service\ViewModel\ServiceViewModel;

class ServiceController extends Controller
{
    private $serviceService;
    public function __construct(ServiceService $serviceService)
    {
        $this->middleware(['auth:admin','prevent-back-history']);
        $this->serviceService = $serviceService;
        $this->middleware('permission:Index-service|Create-service|Edit-service|Delete-service', ['only' => ['index','store']]);
        $this->middleware('permission:Create-service', ['only' => ['create','store']]);
        $this->middleware('permission:Edit-service', ['only' => ['edit','update','activate']]);
        $this->middleware('permission:Delete-service', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['paginated'] = 50;
        $relation = ['category'];
        $intros = $this->serviceService->findAll($data , $relation);
        if($request->ajax()){
            return response()->json(['data' => $intros->items()]);
        }
        return view('service::service.index',['intros' => $intros , 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new ServiceViewModel;
        return view('service::service.create',compact('viewModel'));
    }

    public function store(ServiceRequest $request)
    {
        $serviec = $this->serviceService->save($request->toArray());
        return redirect('/admin/services')->with('created','created');
    }



    public function edit($id)
    {
        $service = $this->serviceService->findById($id);
        $viewModel = new ServiceViewModel;
        return view('service::service.edit',compact('service','viewModel'));
    }


    public function update(ServiceRequest $request, $id)
    {
        $this->serviceService->update($id,$request->toArray());
        return redirect('admin/services')->with('updated','updated');
    }

    public function destroy($id)
    {
        $this->serviceService->delete($id);
        return response()->json(['data' => 'success'],200);
    }

}
