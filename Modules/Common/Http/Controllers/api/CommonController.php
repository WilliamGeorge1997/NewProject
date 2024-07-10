<?php

namespace Modules\Common\Http\Controllers\api;

use Illuminate\Routing\Controller;
use Modules\Common\Service\CommonService;
use Illuminate\Support\Facades\Mail;
use Modules\Common\Entities\Setting;
use Modules\Common\Entities\Slider;
use Modules\Common\Mail\contactUs;
use Modules\Common\Http\Requests\ContactUsRequest;

class CommonController extends Controller
{

    private $CommonService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    public function terms($lang)
    {
        return return_msg(true, 'Terms Data  ', getSetting('terms_'.$lang));
    }

    public function privacy($lang)
    {
        return return_msg(true, 'privacy Data  ', getSetting('privacy_policy_'.$lang));
    }
    public function tax()
    {
        return return_msg(true, 'tax', getSetting('tax'));
    }
    public function refund($lang)
    {
        return return_msg(true, 'refund Data  ', getSetting('refund_'.$lang));
    }

    public function deliveryFees()
    {
        $data = [
            'today_fee' => getSetting('today_fee'),
            'next_day_fee' => getSetting('next_day_fee'),
            'free_delivery_limit' => getSetting('free_delivery_limit'),
            'tax' => getSetting('tax'),
        ];
        return return_msg(true, 'delivery Fees', $data);
    }

    public function about($lang)
    {
        return return_msg(true, 'About Data  ', getSetting('about_'.$lang));
    }

    public function delivery_text($lang)
    {
        $data = [
        'today' => getSetting('today_delivery_text_'.$lang),
        'tomorrow' => getSetting('tomorrow_delivery_text_'.$lang)
    ];
        return return_msg(true, 'About Data  ', $data);
    }

    public function contactUs(ContactUsRequest $request)
    {

        Mail::to(getSetting('email'))->send(new contactUs($request->email, $request->message));

        return return_msg(true, 'Message Sent successfully');
    }

    public function sliders()
    {
        return return_msg(true, 'Slider Data  ', Slider::active()->get());
    }

    public function contactData()
    {

        $data = Setting::whereIn('key',['whatsapp','facebook','instagram'])->select('key','value')->get();
        return return_msg(true, 'Social Media Data', $data);
    }
}
