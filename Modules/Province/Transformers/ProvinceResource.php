<?php

namespace Modules\Province\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\City\Transformers\CityResource;

class ProvinceResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'cities' => CityResource::collection($this->whenLoaded('cities')),

        ];
    }
}
