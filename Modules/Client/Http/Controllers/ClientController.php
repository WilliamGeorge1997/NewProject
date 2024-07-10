<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\DTO\ClientDto;
use Modules\Client\Service\ClientService;
use Modules\Client\Validation\ClientValidation;
use Modules\Common\Helper\UploaderHelper;


class ClientController extends Controller
{

    use UploaderHelper,ClientValidation;
    private $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->middleware(['auth:admin','prevent-back-history']);
        $this->clientService = $clientService;
        $this->middleware('permission:Index-client|Create-client|Edit-client|Delete-client', ['only' => ['index','store']]);
        $this->middleware('permission:Create-client', ['only' => ['create','store']]);
        $this->middleware('permission:Edit-client', ['only' => ['edit','update','activate']]);
        $this->middleware('permission:Delete-client', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $clients = $this->clientService->findAll();
        if($request->ajax()){
            return response()->json(['data' => $clients->items()]);
        }
        return view('client::clients.index',['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('client::clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validation = $this->validateStoreClient($data);
        if ($validation->fails()) return redirect()->back()->withInput()->withErrors($validation);
        $data = (new ClientDto($request))->dataFromRequest();
        $client = $this->clientService->save($data);
        return redirect('admin/clients')->with('created','created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('client::show');
    }

    public function edit($id)
    {
        $client = $this->clientService->findById($id);
        return view('client::clients.edit',compact('client'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validation = $this->validateUpdateClient($data,$id);
        if ($validation->fails()) return redirect()->back()->withErrors($validation);
        $data = (new ClientDto($request))->dataFromRequest();
        $admin = $this->clientService->update($id,$data);
        return redirect('admin/clients')->with('updated','updated');
    }

    public function destroy($id,Request $request)
    {
        $this->clientService->delete($id);
        return response()->json(['data' => 'success'],200);
    }

    public function activate($id){
        $this->clientService->activate($id);
        return redirect('admin/clients')->with('updated','updated');
    }
}
