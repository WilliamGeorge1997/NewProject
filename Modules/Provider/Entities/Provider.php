<?php

namespace Modules\Provider\Entities;

use Modules\Order\Entities\Rate;
use Modules\Service\Entities\Service;
use Modules\Client\Entities\Favourite;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Modules\Service\Entities\SubService;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends Authenticatable implements JWTSubject
{
    use HasFactory,HasTranslations,Notifiable;

    protected $fillable = ['title','description','phone','about','image','website','address','verify_code','fcm_token',
    'work_on_home','lat','lng','work_on_salon','is_active','password','is_slider','category_id'];

    protected $hidden = ['password'];
    protected $appends = ['rate','in_favourite'];


    public $translatable = ['title','description','about'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function scopeInactive($query){
        return $query->where('is_active', 0);
    }
    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function getInFavouriteAttribute()
    {
        if (auth('client')->check()) {
            $favourite = $this->favourites()->where('client_id', auth('client')->id())->first();
            if ($favourite) {
                return 1;
            }
        }
        return 0;
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

                return asset('uploads/provider/' . $value);
            }
        }
    }



    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function getRateAttribute()
    {
       return (double) $this->rates()->avg('provider_rate');
    }

    public function images()
    {
        return $this->hasMany(ProviderGallery::class);
    }

    public function times()
    {
        return $this->hasMany(ProviderOpeningTimes::class);
    }

    public function sub_services()
    {
        return $this->belongsToMany(SubService::class, 'provider_service')->withPivot('price','duration');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
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
}
