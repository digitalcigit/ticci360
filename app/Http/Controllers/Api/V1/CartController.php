<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Http\Requests\CartRequest;
use Botble\Ecommerce\Http\Requests\UpdateCartRequest;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Services\HandleApplyPromotionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Botble\Ecommerce\Facades\OrderHelper;

class CartController extends ApiController
{
    /**
     * Get cart details.
     *
     * @return JsonResponse
     */
    public function index(HandleApplyPromotionsService $applyPromotionsService): JsonResponse
    {
        if (! EcommerceHelper::isCartEnabled()) {
            return $this->error('Cart is disabled', 404);
        }

        $products = [];
        $promotionDiscountAmount = 0;
        $couponDiscountAmount = 0;

        if (Cart::instance('cart')->count() > 0) {
            $products = Cart::instance('cart')->products();
            $promotionDiscountAmount = $applyPromotionsService->execute();
            
            $sessionData = OrderHelper::getOrderSessionData();
            if (session()->has('applied_coupon_code')) {
                $couponDiscountAmount = Arr::get($sessionData, 'coupon_discount_amount', 0);
            }
        }

        return $this->success([
            'instance' => 'cart',
            'count' => Cart::instance('cart')->count(),
            'sub_total' => Cart::instance('cart')->rawSubTotal(),
            'total' => Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount,
            'items' => Cart::instance('cart')->content()->map(function ($item) {
                return [
                    'rowId' => $item->rowId,
                    'id' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'options' => $item->options,
                    'tax' => $item->tax,
                    'subtotal' => $item->subtotal,
                    'image' => $item->model ? get_image_url($item->model->image) : null,
                    'product_link' => $item->model ? route('products.show', $item->id) : null, // Helper for frontend link
                ];
            })->values(),
            'discount_amount' => $promotionDiscountAmount + $couponDiscountAmount,
        ]);
    }

    /**
     * Add item to cart.
     *
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function store(CartRequest $request): JsonResponse
    {
        if (! EcommerceHelper::isCartEnabled()) {
            return $this->error('Cart is disabled', 404);
        }

        $product = Product::find($request->input('id'));

        if (! $product) {
            return $this->error('Product not found', 404);
        }

        if ($product->variations->count() > 0 && ! $product->is_variation) {
            $product = $product->defaultVariation->product;
        }

        if ($product->isOutOfStock()) {
            return $this->error('Product is out of stock', 400);
        }

        if (! $product->canAddToCart($request->input('qty', 1))) {
            return $this->error('Maximum quantity exceeded', 400);
        }

        // Logic handled by OrderHelper to add to Cart instance
        OrderHelper::handleAddCart($product, $request);

        return $this->success([
            'count' => Cart::instance('cart')->count(),
            'message' => __('Added product :product to cart successfully!', ['product' => $product->name]),
        ]);
    }

    /**
     * Update cart item.
     *
     * @param UpdateCartRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCartRequest $request): JsonResponse
    {
        $data = $request->input('items', []);

        foreach ($data as $item) {
            $cartItem = Cart::instance('cart')->get($item['rowId']);
            if (! $cartItem) continue;

            Cart::instance('cart')->update($item['rowId'], Arr::get($item, 'values'));
        }

        return $this->success([
            'count' => Cart::instance('cart')->count(),
            'message' => 'Cart updated successfully',
        ]);
    }

    /**
     * Remove item from cart.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            Cart::instance('cart')->remove($id);
        } catch (\Exception $e) {
            return $this->error('Cart item not found', 404);
        }

        return $this->success([
            'count' => Cart::instance('cart')->count(),
            'message' => 'Item removed from cart',
        ]);
    }
}
