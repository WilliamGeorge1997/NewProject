<?php


namespace Modules\Coupon\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Branch\Entities\Branch;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Entities\Order;

class CouponService
{
    function findAll($relation=[]){
        return Coupon::with($relation)->paginate(50);
    }

    function active(){
        return Coupon::active()->get();
    }

    function findById($id,$relation=[]){
        return Coupon::with($relation)->findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Coupon::where($key, $value)->get();
    }

    function save($data){
        $coupon = Coupon::create($data);
        $coupon->providers()->sync($data['providers']);
        return $coupon;
    }

    function update($id,$data){
        $Coupon = $this->findById($id);
        $Coupon->update($data);
        $Coupon->providers()->sync($data['providers']);
        return $Coupon;
    }

    function activate($id){
        $Coupon = $this->findById($id);
        $Coupon->is_active = !$Coupon->is_active;
        $Coupon->save();
    }
    function delete($id)
    {
        $Coupon = $this->findById($id);
        $Coupon->delete();
    }

    function checkCoupon($code, $provider_id,$client_id)
    {
        $coupon = Coupon::active()->where('code', $code)->first();
        if (!$coupon) return return_msg(false, 'Coupon Not Found', null, 'not_found','api');
        if ($coupon['counter'] >= $coupon['num_of_uses']) return return_msg(false, 'Coupon Has been ended', null, 'not_acceptable','api');
        if (!$coupon->providers()->wherePivot('provider_id', $provider_id)->first()) return return_msg(false, 'Coupon Not Available to this provider', null, 'not_acceptable','api');
        if(Order::whereClientId($client_id)->whereCouponId($coupon->id)->count() >= $coupon['client_uses'] ) return return_msg(false,'Coupon is no longer used for this client', null, 'not_acceptable','api');
        if ($coupon['date_from'] ?? null && $coupon['date_to'] ?? null) {
            if (!($coupon['date_from'] <= Carbon::today()->toDateString() && $coupon['date_to'] >= Carbon::today()->toDateString())) {
                return return_msg(false, 'Coupon Not Available in this date', null, 'not_acceptable','api');
            }
        }
        if ($coupon['time_from'] ?? null && $coupon['time_to'] ?? null) {
            if (!($coupon['time_from'] <= Carbon::now()->toTimeString() && $coupon['time_to'] >= Carbon::now()->toTimeString())) {
                return return_msg(false, 'Coupon Not Available in this time', null, 'not_acceptable','api');
            }
        }
        return $coupon['id'];
    }



}
