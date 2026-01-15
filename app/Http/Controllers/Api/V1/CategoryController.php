<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Get list of categories.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = ProductCategory::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with(['slugable', 'activeChildren']);

        if ($request->boolean('tree', true)) {
            $query->where('parent_id', 0);
        }

        $categories = $query->orderBy('order', 'asc')
            ->get();

        return $this->success(CategoryResource::collection($categories));
    }

    /**
     * Get category details.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = ProductCategory::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('id', $id)
            ->with(['slugable', 'activeChildren'])
            ->first();

        if (! $category) {
            return $this->error('Category not found', 404);
        }

        return $this->success(new CategoryResource($category));
    }
}
