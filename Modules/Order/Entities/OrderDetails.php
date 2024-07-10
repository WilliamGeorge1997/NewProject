<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Service\Entities\SubService;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'price', 'quantity', 'order_id', 'sub_service_id', 'note'];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function sub_service()
    {
        return $this->belongsTo(SubService::class);
    }
}
