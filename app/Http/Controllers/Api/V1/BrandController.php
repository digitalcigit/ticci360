<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Botble\Ecommerce\Models\Brand;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Http\Request;
use Botble\Media\Facades\RvMedia;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query()
            ->where('status', BaseStatusEnum::PUBLISHED);

        if ($request->has('featured')) {
            $query->where('is_featured', 1);
        }

        $brands = $query->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->take($request->input('limit', 20))
            ->get();

        $data = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'website' => $brand->website,
                'logo' => $brand->logo ? RvMedia::getImageUrl($brand->logo) : null,
                'description' => $brand->description,
            ];
        });

        return response()->json([
            'data' => $data
        ]);
    }
}
