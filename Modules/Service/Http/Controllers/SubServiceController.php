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
use Modules\Service\Http\Requests\SubServiceRequest;
use Modules\Service\Service\ServiceService;
use Modules\Service\Service\SubServiceService;
use Modules\Service\ViewModel\ServiceViewModel;
use Modules\Service\ViewModel\SubServiceViewModel;

class SubServiceController extends Controller
{
    private $subServiceService;
    public function __construct(SubServiceService $subServiceService)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->subServiceService = $subServiceService;
        $this->middleware('permission:Index-service|Create-service|Edit-service|Delete-service', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-service', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-service', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-service', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['paginated'] = 50;
        $relation = ['service'];
        $intros = $this->subServiceService->findAll($data, $relation);
        if ($request->ajax()) {
            return response()->json(['data' => $intros->items()]);
        }
        return view('service::sub_service.index', ['intros' => $intros, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new SubServiceViewModel;
        return view('service::sub_service.create', compact('viewModel'));
    }

    public function store(SubServiceRequest $request)
    {
        $serviec = $this->subServiceService->save($request->toArray());
        return redirect('/admin/sub_services')->with('created', 'created');
    }



    public function edit($id)
    {
        $sub_service = $this->subServiceService->findById($id);
        $viewModel = new SubServiceViewModel();
        return view('service::sub_service.edit', compact('sub_service', 'viewModel'));
    }


    public function update(SubServiceRequest $request, $id)
    {
        $this->subServiceService->update($id, $request->toArray());
        return redirect('admin/sub_services')->with('updated', 'updated');
    }

    public function destroy($id)
    {
        $this->subServiceService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }

}
