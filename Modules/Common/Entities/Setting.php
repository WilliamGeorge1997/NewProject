<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";
    protected $fillable = ['value'];
    
    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\SettingFactory::new();
    }
}
