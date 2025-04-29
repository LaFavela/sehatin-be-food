<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->_id,
            'name'        => $this->name,
            'description' => $this->description,
            'calories'    => $this->calories,
            'carb'        => $this->carb,
            'protein'     => $this->protein,
            'fat'         => $this->fat,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
