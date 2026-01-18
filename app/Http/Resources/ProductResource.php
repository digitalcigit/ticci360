<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'description' => $this->description,
            'content' => $this->content, // Detailed description
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'final_price' => $this->front_sale_price, // Helper from model
            'is_on_sale' => $this->front_sale_price < $this->price,
            'image' => $this->image ? get_image_url($this->image) : null,
            'images' => array_map(fn($img) => get_image_url($img), $this->images),
            'stock_status' => $this->stock_status,
            'stock_status_label' => $this->stock_status_label,
            'quantity' => $this->with_storehouse_management ? $this->quantity : null,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ] : null,
            'tags' => $this->tags->pluck('name'),
            'expert_opinion' => $this->getMetaData('expert_opinion', true) ?: null, // Custom field for Story 4.2
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
