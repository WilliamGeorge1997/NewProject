<?php


namespace Modules\Admin\ViewModel;

use Modules\Branch\Entities\Branch;

use Modules\Common\Service\CityService;
use Modules\Company\Service\Company\CompanyService;
use Modules\Country\Service\SubZoneService;
use Modules\Country\Service\ZoneService;
use Modules\Order\Entities\OrderMethod;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\PaymentMethod;

class AdminViewModel
{

    // public function orderMethod()
    // {
    //     return (new OrderMethod())->get();
    // }
    // public function paymentMethod()
    // {
    //     return (new PaymentMethod())->get();
    // }
    public function Companies()
    {
        return (new CompanyService())->active()['data'];
    }
    public function cities()
    {
        return (new CityService())->active();
    }

    public function zones()
    {
        return (new ZoneService())->active();
    }

    public function sub_zones()
    {
        return (new SubZoneService())->active();
    }
    public function orderStatus()
    {
        return (new OrderStatus())->get();
    }
    // public function Branches()
    // {
    //     return (new Branch())->get();
    // }

    public function recentMinusOneMinute($Object)
    {
        return   $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل الان';
            $data->ButtonColor = 'success' ;
            $data->firstSubmitButton = 'الموافقة على الطلب';
            $data->secondSubmitButton = 'رفض الطلب';
            return $data;
        });
    }
    public function recentMinusTwoMinutes($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل منذ اكثر من دقيقة';
            $data->ButtonColor = 'warning';
            $data->firstSubmitButton = 'الموافقة على الطلب';
            $data->secondSubmitButton = 'رفض الطلب';
            return $data;
        });
    }
    public function recentPlusTwoMinute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل منذ اكثر من دقيقتين';
            $data->ButtonColor = 'danger';
            $data->firstSubmitButton = 'الموافقة على الطلب';
            $data->secondSubmitButton = 'رفض الطلب';
            return $data;
        });
    }

    public function acceptMinus15Minute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'جارى تحضيره منذ اقل من 15 دقيقة';
            $data->ButtonColor = 'success';

            if ($data->order_method_id == 2) {
                $data->firstSubmitButton = '';
            } else {
                $data->firstSubmitButton = 'الطلب جاهز للتسليم';
            }

            $data->secondSubmitButton = '';
            return $data;
        });
    }

    public function acceptPlus15Minus20Minute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'جارى تحضيره منذ اكثر من 15 دقيقة' ;
            $data->ButtonColor = 'warning';
            if ($data->order_method_id == 2) {
                $data->firstSubmitButton = '';
            } else {
                $data->firstSubmitButton = 'الطلب جاهز للتسليم';
            }

            $data->secondSubmitButton = '';
            return $data;
        });
    }
    public function acceptPlus20Minute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'جارى تحضيره منذ اكثر من 20 دقيقة' ;
            $data->ButtonColor = 'danger';
            if ($data->order_method_id == 2) {
                $data->firstSubmitButton = '';
            } else {
                $data->firstSubmitButton = 'الطلب جاهز للتسليم';
            }

            $data->secondSubmitButton = '';
            return $data;
        });
    }
    public function MainReadyData($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = '';
            $data->ButtonColor = 'info';
            if($data->order_method_id==3)
            {
                $data->firstSubmitButton = 'تسليم للسائق';
            }
            else{
                $data->firstSubmitButton = 'تم الاستلام بنجاح';
            }
            $data->secondSubmitButton = '';
            return $data;
        });
    }

    public function FrontOfBranchMinusOneMinute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل الان';
            $data->ButtonColor = 'success';
            $data->firstSubmitButton = 'تم الاستلام بنجاح';
            $data->secondSubmitButton = '';
            return $data;
        });
    }

    public function FrontOfBranchMinusTwoMinutes($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل منذ اكثر من دقيقة';
            $data->ButtonColor = 'info';
            $data->firstSubmitButton = 'تم الاستلام بنجاح';
            $data->secondSubmitButton = '';
            return $data;
        });
    }

    public function FrontOfBranchPlusTwoMinute($Object)
    {
        $Object->map(function ($data) {
            $data->OrderStatusVal = 'وصل منذ اكثر من دقيقتين';
            $data->ButtonColor = 'danger';
            $data->firstSubmitButton = 'تم الاستلام بنجاح';
            $data->secondSubmitButton = '';
            return $data;
        });
    }
}
