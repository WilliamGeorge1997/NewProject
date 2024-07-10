<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Service\OrderStatusService;
use Modules\Common\Helper\UploaderHelper;
use Modules\Order\DTO\OrderStatusDto;
use Modules\Order\Http\Requests\OrderStatusRequest;

class OrderStatusController extends Controller
{
    use UploaderHelper;
    private $OrderStatusService;
    public function __construct(OrderStatusService $OrderStatusService)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->OrderStatusService = $OrderStatusService;
        $this->middleware('permission:Index-orderstatus|Create-orderstatus|Edit-orderstatus|Delete-orderstatus', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-orderstatus', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-orderstatus', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-orderstatus', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $orderStatus = $this->OrderStatusService->findAll();
        if ($request->ajax())
            return response()->json(['data' => $orderStatus]);

        return view('order::orderstatus.index', ['orderStatus' => $orderStatus]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('order::orderstatus.create');
    }

    public function store(OrderStatusRequest $request)
    {
        $data = $this->OrderStatusService->save((new OrderStatusDto($request))->dataFromRequest());
        return $data;
        return redirect('/admin/orderstatus')->with('created', 'created');
    }

    public function edit($id)
    {
        $orderstatus = $this->OrderStatusService->findById($id);
        return view('order::orderstatus.edit', compact('orderstatus'));
    }

    public function update(OrderStatusRequest $request, $id)
    {
        $this->OrderStatusService->update($id, (new OrderStatusDto($request))->dataFromRequest());
        return redirect('admin/orderstatus')->with('updated', 'updated');
    }

    public function destroy($id, Request $request)
    {
        $this->OrderStatusService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }
}
