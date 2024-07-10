<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;
use Modules\Client\Entities\Client;
use Modules\Driver\Entities\Driver;
use Modules\Provider\Entities\Provider;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id','order_id','provider_rate','service_rate','comment','client_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

}
