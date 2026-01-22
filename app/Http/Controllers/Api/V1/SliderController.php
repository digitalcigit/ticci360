<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Http\Request;
use Botble\Media\Facades\RvMedia;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        // Allow filtering by key (e.g., ?key=home-slider)
        $key = $request->input('key', 'home-slider');

        $slider = SimpleSlider::where('key', $key)
            ->where('status', 'published')
            ->with(['sliderItems' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
            ->first();

        if (!$slider) {
            return response()->json([
                'data' => [],
                'message' => 'Slider not found'
            ], 404);
        }

        $slides = $slider->sliderItems->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'image' => RvMedia::getImageUrl($item->image),
                'tablet_image' => $item->getMetaData('tablet_image', true) ? RvMedia::getImageUrl($item->getMetaData('tablet_image', true)) : null,
                'mobile_image' => $item->getMetaData('mobile_image', true) ? RvMedia::getImageUrl($item->getMetaData('mobile_image', true)) : null,
                'link' => $item->link,
                'description' => $item->description,
                'order' => $item->order,
            ];
        });

        return response()->json([
            'data' => $slides
        ]);
    }
}
