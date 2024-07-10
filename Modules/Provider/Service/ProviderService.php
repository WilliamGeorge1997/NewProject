<?php


namespace Modules\Provider\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Category\Entities\Category;
use Modules\Common\Entities\Image;
use Modules\Common\Helper\UploaderHelper;
use Modules\Employee\Entities\Employee;
use Modules\Order\Entities\Rate;
use Modules\Package\Entities\Package;
use Modules\Provider\Entities\Provider;
use Modules\Provider\Entities\ProviderGallery;
use Modules\Service\Entities\Service;

class ProviderService
{
    use UploaderHelper;

    function findAll($data)
    {
        return Provider::with('category')
            ->when($data['category_id'] ?? null, function ($q) use ($data) {
                return $q->where('category_id', $data['category_id']);
            })
            ->when(isset($data['query']), function ($q) use ($data) {
                return $q->where('title', 'like', '%' . $data['query'] . '%')
                    ->orWhere('phone', 'like', '%' . $data['query'] . '%');
            })
            ->paginate(50);
    }

    function active($relation = [])
    {
        return Provider::with($relation)->active()->get();
    }


    function findById($id, $relation = [])
    {
        return Provider::with($relation)->findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Provider::where($key, $value)->get();
    }

    function save($data)
    {
        DB::beginTransaction();

        try {
            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $imageName = $this->upload($image, 'provider');
                $data['image'] = $imageName;
            }

            $provider = Provider::create($data);
            if (request()['work_images'] ?? null) {
                foreach (request()['work_images'] as $image) {
                    $imageName = $this->upload($image, 'provider/work');
                    $provider->images()->create(['image' => $imageName]);
                }
            }
            DB::commit();
            return $provider;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

    function update($id, $data)
    {
        $Provider = $this->findById($id);
        if (request()->hasFile('image')) {
            File::delete(public_path('uploads/provider/' . $this->getImageName('provider', $Provider->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'provider');
            $data['image'] = $imageName;
        }
        $Provider->update($data);
        return $Provider;
    }

    function activate($id)
    {
        $Provider = $this->findById($id);
        $Provider->is_active = !$Provider->is_active;
        $Provider->save();
    }

    function delete($id)
    {
        $Provider = $this->findById($id);
        $Provider->delete();
    }

    function StoreServices($data)
    {
        $Provider = $this->findById($data['provider_id']);
        $data = $this->prepareDataForSync($data['services']);
        $Provider->sub_services()->sync($data);
    }

    function StoreTimes($data)
    {
        $Provider = $this->findById($data['provider_id']);
        foreach ($data['times'] as $time) {
            $Provider->times()->create($time);
        }
    }

    function getProviderSubServices($provider_id)
    {
        $Provider = $this->findById($provider_id);
        return $Provider->sub_services()->get();
    }

    function getServicesWithSubServices($provider_id, $paginate = null)
    {
        if ($paginate ?? null)
            return Service::whereRelation('sub_services.providers', 'provider_id', $provider_id)
                ->with([
                    'sub_services' => function ($query) use ($provider_id) {
                        $query->whereRelation('providers', 'provider_id', $provider_id)
                            ->with([
                                'providers' => function ($q) use ($provider_id) {
                                    $q->where('id', $provider_id)->select('id');
                                }
                            ]);
                    }
                ])->paginate($paginate);
        // get category that has service assigned to specific provider
        else
            return Service::whereRelation('sub_services.providers', 'provider_id', $provider_id)
                ->with([
                    'sub_services' => function ($query) use ($provider_id) {
                        $query->whereRelation('providers', 'provider_id', $provider_id)
                            ->with([
                                'providers' => function ($q) use ($provider_id) {
                                    $q->where('id', $provider_id)->select('id');
                                }
                            ]);
                    }
                ])->get();
    }

    function prepareDataForSync($data)
    {
        $result = [];
        foreach ($data as $datum) {
            $result[$datum['id']] = ['price' => $datum['price'], 'duration' => $datum['duration']];
        }
        return $result;
    }


    function nearbyProviders($data,$relation=[])
    {
        if (isset($data['lat']) && isset($data['lng'])) {

            $providers = Provider::query()
                ->with($relation)
                ->select(
                '*',
                DB::raw("6371 * acos(cos(radians(" . $data['lat'] . "))
                    * cos(radians(providers.lat))
                    * cos(radians(providers.lng) - radians(" . $data['lng'] . "))
                    + sin(radians(" . $data['lat'] . "))
                    * sin(radians(providers.lat))) AS distance")
            )
                ->orderBy('distance', 'ASC')
                ->when($data['category_id'] ?? null, function ($q) use ($data) {
                    $q->where('category_id', $data['category_id']);
                })
                ->withCount('rates')
                ->paginate();

        } else {
            $providers = Provider::query()
                ->with($relation)
                ->when($data['category_id'] ?? null, function ($q) use ($data) {
                    $q->where('category_id', $data['category_id']);
                })->withCount('rates')->paginate();

        }
        return $providers;
    }

    function sliderProviders($lat, $lng,$relation=[])
    {

        if (isset($lat) && isset($lng)) {

            $providers = Provider::query()
                ->with($relation)
                ->select(
                '*',
                DB::raw("6371 * acos(cos(radians(" . $lat . "))
                    * cos(radians(providers.lat))
                    * cos(radians(providers.lng) - radians(" . $lng . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(providers.lat))) AS distance")
            )
                ->orderBy('distance', 'ASC')
                ->where('is_slider', 1)
                ->limit(5)
                ->withCount('rates')
                ->get();

        } else {
            $providers = Provider::query()->with($relation)
                ->where('is_slider', 1)
                ->limit(5)
                ->withCount('rates')
                ->get();

        }
        return $providers;

    }

    function images($provider_id, $paginate)
    {
        $Provider = $this->findById($provider_id);
        $data = $Provider->images()->paginate($paginate);
        return $data;
    }

    function rates($provider_id, $paginate)
    {
        $base = Rate::whereProviderId($provider_id)->with('client')->latest();
        $data['avg'] = $base->avg('provider_rate');
        $data['count'] = $base->count();
        $data['reviews'] = $base->whereNotNull('comment')->paginate($paginate);
        return $data;
    }

    function employees($provider_id, $paginate = false)
    {
        if ($paginate)
            return Employee::with('services')->whereProviderId($provider_id)->paginate($paginate);
        else
            return Employee::with('services')->whereProviderId($provider_id)->get();
    }

    function packages($provider_id, $paginate = false)
    {
        if ($paginate)
            return Package::with('services')->whereProviderId($provider_id)->paginate($paginate);
        else
            return Employee::with('services')->whereProviderId($provider_id)->get();
    }

    function saveWorkImages($provider_id)
    {
        $provider = $this->findById($provider_id);
        if (request()['work_images'] ?? null) {
            foreach (request()['work_images'] as $image) {
                $imageName = $this->upload($image, 'provider/work');
                $provider->images()->create(['image' => $imageName]);
            }
        }
    }

    function deleteWorkImage($image_id)
    {
        $image = ProviderGallery::whereId($image_id)->first();
        File::delete(public_path('uploads/provider/work/' . $this->getImageName('provider/work', $image->image)));
        $image->delete();
    }
}
