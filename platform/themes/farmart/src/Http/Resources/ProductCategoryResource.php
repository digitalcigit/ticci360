<?php

namespace Theme\Farmart\Http\Resources;

use Botble\Ecommerce\Models\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use Botble\Media\Facades\RvMedia;

/**
 * @mixin ProductCategory
 */
class ProductCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'slug' => $this->slug,
            'image' => RvMedia::getImageUrl($this->image, null, false, RvMedia::getDefaultImage()),
            'thumbnail' => RvMedia::getImageUrl($this->image, 'small', false, RvMedia::getDefaultImage()),
        ];
    }
}
