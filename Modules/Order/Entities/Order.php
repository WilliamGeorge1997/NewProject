<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Client\Entities\Address;
use Modules\Client\Entities\Client;
use Modules\Country\Entities\SubZone;
use Modules\Country\Entities\Zone;
use Modules\Coupon\Entities\Coupon;
use Modules\Driver\Entities\Driver;
use Modules\Driver\Service\DriverService;
use Modules\Provider\Entities\Provider;

class Order extends Model
{
    use HasFactory;

    const DISCOUNT_WITH_COUPON = 1;
    const DISCOUNT_WITH_POINTS = 2;

    protected $fillable = [
         'subtotal', 'discount', 'discount_type', 'tax', 'total', 'quantity', 'client_id','reservation_date',
        'notes', 'order_status_id', 'provider_id', 'coupon_id', 'order_no','address','reservation_time','place'
    ];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }


    public function rate()
    {
        return $this->hasOne(Rate::class);
    }


    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }
    public function histories()
    {
        return $this->hasMany(History::class, 'order_id');
    }


    public function lastHistory()
    {
        // Assuming 'created_at' is the timestamp indicating when the history was created.
        return $this->hasOne(History::class)->latest();
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

}
