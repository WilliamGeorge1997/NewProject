<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;
use Modules\Common\Helper\Uuid;
use Modules\Employee\Entities\Employee;
use Modules\Order\Entities\OrderDetails;
use Modules\Package\Entities\Package;
use Modules\Provider\Entities\Provider;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = ['title', 'is_active', 'order','category_id'];
    public $translatable = ['title'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function sub_services(){
        return $this->hasMany(SubService::class);
    }

}
