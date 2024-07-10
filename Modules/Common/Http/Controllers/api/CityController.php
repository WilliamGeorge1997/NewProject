<?php

namespace Modules\Common\Http\Controllers\api;

use Illuminate\Routing\Controller;
use Modules\Common\Service\CommonService;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Mail\contactUs;
use Modules\Common\Http\Requests\ContactUsRequest;
use Modules\Common\Service\CityService;

class CityController extends Controller
{

    private $cityService;
    public function __construct(CityService $cityService)
    {
        // $this->middleware(['auth:employee']);
        $this->cityService = $cityService;
    }

    public function index()
    {
        $data = $this->cityService->active();
        return return_msg(true,'cities',$data);
    }

}
