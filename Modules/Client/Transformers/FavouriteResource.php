<?php

namespace Modules\Client\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->product->id,
            'title' => $this->product->title,
            'description' => $this->product->description,
            'upc' => $this->product->upc,
            'image' => @$this->product->last_image->image,
            'brand' => $this->product->brand,
        ];
    }
}
