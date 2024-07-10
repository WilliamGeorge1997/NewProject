<?php

namespace Modules\Admin\Entities;

use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\History;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, HasRoles, CausesActivity, LogsActivity;

    protected $fillable = ['name', 'email', 'phone', 'image', 'password', 'is_active'];
    protected $hidden = ['password'];
    protected static $logName = 'Admin';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

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

                return asset('uploads/admin/' . $value);
            }
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function histories()
    {
        return $this->morphMany(History::class, 'historible');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeAvailable($query)
    {
        if (Auth::check('admin')) {
            $admin = Auth::user();
            if ($admin->company_id ?? null && is_null($admin->branch_id)) {
                // show only specific branch
                $query->where('company_id', $admin->company_id);
            }
            if ($admin->branch_id ?? null) {
                // show only specific branch
                $query->where('branch_id', $admin->branch_id);
            }
        }
    }
}
