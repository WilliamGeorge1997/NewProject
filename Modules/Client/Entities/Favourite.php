<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Provider\Entities\Provider;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','provider_id'];
    protected $hidden = ['created_at','updated_at'];


    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

}
