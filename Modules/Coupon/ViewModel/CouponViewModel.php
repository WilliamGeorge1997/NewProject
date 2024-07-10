<?php


namespace Modules\Coupon\ViewModel;



use Modules\Provider\Service\ProviderService;

class CouponViewModel
{
    public function providers(){
        return (new ProviderService())->active([]);
    }

}
