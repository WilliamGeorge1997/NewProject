<?php

namespace Modules\Provider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderEmployeesResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'image' => $this->image,
            'work_from' => $this->work_from,
            'work_to' => $this->work_to,
            'work_out' => $this->work_out,
            'holidays' => $this->holidays,
            'services' => EmployeeServicesResource::collection($this->services),
        ];
    }
}
