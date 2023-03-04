<?php

namespace App\Http\Resources\Players;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'number'    => $this->number,
            'position'  => $this->position,
            'weight'    => $this->weight,
            'height'    => $this->height,
            'age'       => $this->age,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
