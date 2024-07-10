<?php

namespace Modules\Provider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceWithProviderSubServicesResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => ['en'=>$this->getTranslation('title', 'en'),'ar'=>$this->title],
            'sub_services' => ProviderSubServiceResource::collection($this->sub_services),
        ];
    }
}
