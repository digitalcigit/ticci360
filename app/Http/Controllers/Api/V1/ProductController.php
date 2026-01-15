<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Get list of products.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('is_variation', 0)
            ->with(['slugable', 'brand', 'tags', 'categories']);

        // Basic Filtering (preparatory for Epic 2)
        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->input('category_id'));
            });
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 12));

        return $this->success(
            ProductResource::collection($products)->response()->getData(true)
        );
    }

    /**
     * Get product details.
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = Product::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('is_variation', 0)
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('sku', $id);
            })
            ->with(['slugable', 'brand', 'tags', 'categories', 'variations', 'images'])
            ->first();

        if (! $product) {
            // Try looking up by slug if not found by ID/SKU
            // Note: In Botble, slugs are usually in a separate table, but let's assume direct lookup or slugable relation
            // For now, simpler error.
            return $this->error('Product not found', 404);
        }

        return $this->success(new ProductResource($product));
    }
}
