<?php

namespace Modules\Provider\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderOpeningTimes extends Model
{
    use HasFactory;

    protected $fillable = ['provider_id','day','open_at','close_at','is_holiday'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

}
