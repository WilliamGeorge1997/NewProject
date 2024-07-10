<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = ['title','description','image'];
    public $translatable = ['title','description'];

    public $hidden = ['updated_at'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }


    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            return asset('uploads/slider/' . $value);
        }
        return $value;
    }
    
    
}
