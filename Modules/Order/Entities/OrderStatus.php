<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class OrderStatus extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title'];
    public $translatable = ['title'];

    protected $table = "order_statuses";
    public $hidden = ['updated_at'];



    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
}
