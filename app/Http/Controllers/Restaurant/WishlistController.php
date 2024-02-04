<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\WishlistRequest;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $wishlists = Wishlist::with(['product' => function ($query) {
                $query->select('id', 'category_id', 'image', 'name', 'slug', 'ingredients', 'base_price', 'discount_price')
                ->filterBy(request(['rating', 'category']))
                ->withPublishedReviewCount()
                ->withPublishedReviewAvg();
            }])
                ->where('user_id', auth()->id())
                ->get();

            return response()->json($wishlists, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(WishlistRequest $request): JsonResponse
    {
        try {
            $addons = $request->addons;

            $newWishlist = Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'addons' => count($addons) ? json_encode($addons) : null,
            ]);

            return response()->json($newWishlist, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Wishlist $wishlist): Response
    {
        try {
            $wishlist->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
