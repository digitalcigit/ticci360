<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug, // Assuming standard Botble slug handling, might need adjustment
            'description' => $this->description,
            'image' => $this->image ? get_image_url($this->image) : null,
            'parent_id' => $this->parent_id,
            'children' => CategoryResource::collection($this->whenLoaded('activeChildren')),
            'products_count' => $this->products_count,
        ];
    }
}
