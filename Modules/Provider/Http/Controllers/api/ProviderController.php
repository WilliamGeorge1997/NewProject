<?php

namespace Modules\Provider\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Provider\Http\Requests\ProviderOpeningTimesRequest;
use Modules\Provider\Http\Requests\ProviderRequest;
use Modules\Provider\Http\Requests\ProviderServicesRequest;
use Modules\Provider\Http\Requests\ProviderUpdateRequest;
use Modules\Provider\Service\ProviderService;
use Modules\Provider\Transformers\CategoryWithProviderServicesResource;
use Modules\Provider\Transformers\ProviderEmployeesResource;
use Modules\Provider\Transformers\ServiceWithProviderSubServicesResource;

class ProviderController extends Controller
{
    private $providerService;
    public function __construct(ProviderService $providerService)
    {
        // $this->middleware(['auth:admin_api']);
        $this->providerService = $providerService;
    }

    public function index()
    {
        $providers = $this->providerService->active();
        return return_msg(true,'All Providers',$providers);
    }


    public function store(ProviderRequest $request)
    {
        DB::beginTransaction();

        try {
            $Provider = $this->providerService->save($request->all());
            $token = auth('provider')->login($Provider);
            DB::commit();
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollback();
        }
        // return return_msg(true, 'Provider Created Successfully', $Provider);
    }

    public function updateAuthProvider(ProviderUpdateRequest $request)
    {
        $Provider = $this->providerService->update(auth('provider')->id(),$request->all());
        return return_msg(true, 'Provider Updated Successfully', $Provider);
    }

    public function destroy($id)
    {
        $this->providerService->delete($id);
        return return_msg(true, 'Provider Deleted Successfully');
    }

    public function activate($id){
        $this->providerService->activate($id);
        return return_msg(true, 'Provider Updated Successfully');
    }

    public function StoreServices(ProviderServicesRequest $request)
    {
         $this->providerService->storeServices($request->toArray());
        return return_msg(true, 'Services assigned to provider successfully');
    }

    public function StoreTimes(ProviderOpeningTimesRequest $request)
    {
        $this->providerService->StoreTimes($request->toArray());
        return return_msg(true, 'Times assigned to provider successfully');
    }

    public function sub_services()
    {
        $data = $this->providerService->getProviderSubServices(auth('provider')->id());
        return return_msg(true, 'Provider Services',$data);
    }

    public function servicesWithSubServices(Request $request)
    {
        $data = $this->providerService->getServicesWithSubServices(auth('provider')->id());
        return return_msg(true, 'Provider categories with Services',$data);
    }

    public function NearbyProviders(Request $request)
    {
        $data = $this->providerService->nearbyProviders($request->all(),['times']);
        return return_msg(true, 'Nearby Providers',$data);

    }

    public function SliderProviders(Request $request)
    {
        $data = $this->providerService->sliderProviders($request['lat'],$request['lng'],['times']);
        return return_msg(true, 'Slider Providers',$data);

    }

    public function show($provider_id)
    {
        $data = $this->providerService->findById($provider_id,['times']);
        return return_msg(true, 'Provider Details',$data);

    }


    public function providerServicesWithSubServices($provider_id,Request $request)
    {
        // $paginate = $request['paginate'] ? $request['paginate'] : 5 ;
        $data = $this->providerService->getServicesWithSubServices($provider_id);
        $data = ServiceWithProviderSubServicesResource::collection($data);
        return return_msg(true, 'Provider categories with Services',$data);
    }

    public function providerImages($provider_id,Request $request)
    {
        $paginate = $request['paginate'] ? $request['paginate'] : 5 ;
        $data = $this->providerService->images($provider_id,$paginate);
        return return_msg(true, 'Provider work images',$data);
    }

    public function providerAuthImages(Request $request)
    {
        $paginate = $request['paginate'] ? $request['paginate'] : 5 ;
        $data = $this->providerService->images(auth('provider')->id(),$paginate);
        return return_msg(true, 'Provider work images',$data);
    }

    public function providerRates($provider_id,Request $request)
    {
        $paginate = $request['paginate'] ? $request['paginate'] : 5 ;
        $data = $this->providerService->rates($provider_id,$paginate);
        return return_msg(true, 'Provider Reviews',$data);
    }


    public function providerData()
    {
        $provider_id = auth('provider')->id();
        $provider = $this->providerService->findById($provider_id);
        return return_msg(true, 'Provider Data',$provider);
    }
    public function addWorkImages()
    {
        $provider_id = auth('provider')->id();
        $this->providerService->saveWorkImages($provider_id);
        return return_msg(true, 'Provider Work Images Added Successffully');
    }

    public function deleteWorkImage($image_id)
    {
        $this->providerService->deleteWorkImage($image_id);
        return return_msg(true, 'Provider Work Images Deleted Successffully');
    }

    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('provider')->factory()->getTTL() * 60,
            'provider' => \auth('provider')->user(),
        ];
        return return_msg(true, 'Authenticated Provider', $data);
    }

}
