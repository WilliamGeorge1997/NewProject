<?php

namespace Modules\Provider\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderGallery extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id', 'image'];


    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {

            if (filter_var($value, FILTER_VALIDATE_URL)) {

                return $value;
            } else {

                return asset('uploads/provider/work/' . $value);
            }
        }
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
