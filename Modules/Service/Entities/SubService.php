<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Provider\Entities\Provider;
use Spatie\Translatable\HasTranslations;

class SubService extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = ['title', 'is_active', 'order','service_id','image','duration','price' ,'range'];
    public $translatable = ['title'];


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }


    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {

            if (filter_var($value, FILTER_VALIDATE_URL)) {

                return $value;
            } else {

                return asset('uploads/service/' . $value);
            }
        }
    }


    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'provider_service')->withPivot('price','duration');
    }
}
