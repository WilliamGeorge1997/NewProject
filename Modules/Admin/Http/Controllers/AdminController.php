<?php

namespace Modules\Admin\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Admin\DTO\AdminDto;
use Modules\Order\Entities\Rate;
use Modules\Admin\Entities\Admin;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Client\Entities\Client;
use Modules\Driver\Entities\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Product;
use Modules\Service\Entities\Service;
use Modules\Admin\Service\RoleService;
use Modules\Admin\Service\AdminService;
use Modules\Category\Entities\Category;
use Modules\Provider\Entities\Provider;
use Modules\Service\Entities\SubService;
use Modules\Branch\Service\BranchService;
use Modules\Common\Helper\UploaderHelper;
use Modules\Admin\ViewModel\AdminViewModel;
use Modules\Order\ViewModel\OrderViewModel;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Validation\AdminValidation;
use Modules\Admin\Http\Resources\OrderCardsResource;

class AdminController extends Controller
{
    use UploaderHelper, AdminValidation;
    private $adminService, $AdminViewModel;
    public function __construct(AdminService $adminService, AdminViewModel $AdminViewModel)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->adminService = $adminService;
        $this->middleware('permission:Index-admin|Create-admin|Edit-admin|Delete-admin', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit-admin', ['only' => ['edit', 'update', 'activate']]);
        $this->middleware('permission:Delete-admin', ['only' => ['destroy']]);
        $this->AdminViewModel = $AdminViewModel;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function dashboard()
    {
        $date = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->month;
        $todayClientsCount = Client::whereDate('created_at', $date)->count();
        $todayProvidersCount = Provider::whereDate('created_at', $date)->count();
        $todayOrdersCount = Order::whereDate('created_at', $date)->count();
        $activeClientsCount = Client::active()->count();
        $inactiveClientsCount = Client::inactive()->count();
        $activeServicesCount = Service::active()->count();
        $activeSubservicesCount = SubService::active()->count();
        $activeProvidersCount = Provider::active()->count();
        $inactiveProvidersCount = Provider::inactive()->count();
        $latestOrders = Order::select('id', 'order_no', 'total', 'reservation_date', 'client_id')->with('client:id,name,phone')->latest()->take(5)->get();
        $ordersThisMonth = Order::whereMonth('created_at', $currentMonth)->count();
        $activeCategoriesCount = Category::active()->count();
        $inactiveCategoriesCount = Category::inactive()->count();
        $profitThisMonth = Order::whereMonth('created_at', $currentMonth)->sum('total');
        $topProviders = Provider::select('title', 'phone', 'image')
            ->withCount('rates')
            ->withAvg('rates', 'provider_rate')
            ->having('rates_count', '>', '0')
            ->orderByDesc('rates_avg_provider_rate')
            ->take(5)
            ->get();


        return view(
            'admin::index',
            compact(
                'todayClientsCount',
                'todayProvidersCount',
                'todayOrdersCount',
                'activeClientsCount',
                'inactiveClientsCount',
                'activeServicesCount',
                'activeSubservicesCount',
                'activeProvidersCount',
                'inactiveProvidersCount',
                'latestOrders',
                'ordersThisMonth',
                'activeCategoriesCount',
                'inactiveCategoriesCount',
                'profitThisMonth',
                'topProviders',

            )
        );
    }

    public function index(Request $request)
    {
        $admins = $this->adminService->findAll();
        $roles = (new RoleService())->findAll(['id', 'name']);
        if ($request->ajax()) {
            return response()->json(['data' => $admins]);
        }
        return view('admin::admins.index', ['admins' => $admins, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = (new RoleService())->findAll(['id', 'name']);
        return view('admin::admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $data = (new AdminDto($request))->dataFromRequest();
        $validation = $this->validateStore($data);
        if ($validation->fails())
            return redirect()->back()->withInput()->withErrors($validation);
        $admin = $this->adminService->save($data);
        return redirect('admin/admins')->with('created', 'created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $admin = $this->adminService->findById($id);
        $roles = (new RoleService())->findAll(['id', 'name']);
        $userRole = $admin->roles->pluck('name', 'name')->all();
        return view('admin::admins.edit', compact('admin', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data = (new AdminDto($request))->dataFromRequest();
        $validation = $this->validateUpdate($data, $id);
        if ($validation->fails())
            return redirect()->back()->withInput()->withErrors($validation);
        $admin = $this->adminService->update($id, $data);
        return redirect('admin/admins')->with('updated', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        $this->adminService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }

    public function activate($id)
    {
        $this->adminService->activate($id);
        return redirect('admin/admins')->with('updated', 'updated');
    }
}
