<?php

namespace Modules\Category\Entities;

use Modules\Banner\Entities\Banner;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Provider\Entities\Provider;
use Modules\Order\Entities\OrderDetails;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title', 'is_active', 'image', 'order'];

    public $translatable = ['title'];


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
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

                return asset('uploads/category/' . $value);
            }
        }
    }


    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetails::class, Product::class);
    }
}
