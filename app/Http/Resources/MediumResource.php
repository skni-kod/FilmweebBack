<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediumResource extends JsonResource
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
            'title' => $this->title,
            'original_title' => $this->original_title,
            'release_date' => $this->release_date,
            'overview' => $this->overview,
            'duration' => $this->duration,
            'type' => $this->type,
            'image_path' => $this->image_path ? Storage::disk('google')->url($this->image_path) : $this->image_path,
            'avg_rating' => ($this->avg_grade) ? (int)($this->avg_grade) : 0,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}
