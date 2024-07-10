<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\Order;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = ['title','description','image','notifiable_id','notifiable_type','read_at','order_id','group_by'];
    public $translatable = ['title','description'];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
    
    public function notifiable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/notification/' . $value);
        }
        return $value;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
