<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

class CastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'medium_id' => $this->medium_id,
            'person_data' => new PersonResource($this->person),
            'gender_id' => $this->gender,
            'character' => $this->character,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
        ];
    }
}
