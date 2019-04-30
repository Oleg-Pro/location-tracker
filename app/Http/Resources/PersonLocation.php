<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonLocation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'person' => $this->person,
          'latitude' =>  $this->latitude,
          'longitude' =>  $this->longitude,
          'created_at' =>  $this->created_at->toDateTimeString(),
          'updated_at' =>  $this->updated_at->toDateTimeString(),
        ];
    }
}
