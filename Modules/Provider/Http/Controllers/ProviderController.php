<?php

namespace Modules\Provider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Provider\Service\ProviderService;

class ProviderController extends Controller
{
    private $providerService;

    public function __construct(ProviderService $providerService){
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->providerService = $providerService;
        $this->middleware('permission:Index-service|Create-service|Edit-service|Delete-service', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-service', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-service', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-service', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $providers = $this->providerService->findAll($request->all());
        if($request->ajax()){
            return response()->json(['data' => $providers->items()]);
        }
        return view('provider::provider.index' , ['providers' => $providers,'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('provider::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $provider = $this->providerService->findById($id , ['category' , 'sub_services.service' , 'times' , 'images' , 'rates' ]);
        $services = $this->providerService->getServicesWithSubServices($id);
        return view('provider::provider.view' , ['provider' => $provider , 'services' => $services]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('provider::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $provider = $this->providerService->update($id, $data);
        return redirect('admin/providers')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function activate($id){
        $this->providerService->activate($id);
        return redirect('admin/providers')->with('updated', 'updated');
    }

}
