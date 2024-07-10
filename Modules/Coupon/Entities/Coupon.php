<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Branch\Entities\Branch;
use Modules\Provider\Entities\Provider;
use Spatie\Activitylog\Traits\LogsActivity;

class Coupon extends Model
{
    use HasFactory,LogsActivity;

    const FIXED = 1;
    const PERCENT = 2;

    protected $fillable = ['code','is_active','num_of_uses','counter','type','value','limit','date_from',
    'date_to','time_from','time_to','client_uses','discount_on'];

    protected static $logName  = 'Coupon';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;



    public function providers(){
        return $this->belongsToMany(Provider::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function discount($total){
        $this->counter++;
        $this->save();
        if ($this->type == self::FIXED){
            return min($this->value,$total);
        }else{
            $discount =(int) ($total * $this->value) / 100;
            if($this->limit > 0 && $discount > $this->limit) return $this->limit;
            return $discount;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeAvailable($query)
    {
        if (Auth::check('admin')) {
            $admin = Auth::user();
            if ($admin->company_id ?? null && is_null($admin->branch_id)) {
                return $query->whereHas('branches', function ($q) use ($admin) {
                    $q->whereHas('company',function ($q) use ($admin){
                        $q->where('id',$admin->company_id);
                    });
                });
            }
            if ($admin->branch_id ?? null) {
                // show only specific branch
                $query->whereHas('branches', function ($q) use ($admin) {
                    $q->where('branch_id',$admin->branch_id);
                });
            }
        }
    }
}
