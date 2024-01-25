<?php

namespace App\Http\Controllers\Admin\Products;

use App\Actions\Admin\Products\CreateProductAction;
use App\Actions\Admin\Products\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\Products\ProductResource;
use App\Models\AdditionalImage;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products.view', ['only' => ['index']]);
        $this->middleware('permission:products.create', ['only' => ['store']]);
        $this->middleware('permission:products.edit', ['only' => ['show','update']]);
        $this->middleware('permission:products.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $products = Product::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder->with('category:id,name')
                    ->filterBy(request(['status','category']));
                })
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $product = (new CreateProductAction())->handle($request->validated());

            return response()->json($product, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Product $product): ProductResource
    {
        try {
            return new ProductResource($product);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        try {
            $product = (new UpdateProductAction())->handle($request->validated(), $product);

            return response()->json($product, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Product $product): Response
    {
        try {

            $additionalImages = AdditionalImage::where("product_id", $product->id)->get();

            $additionalImages->each(function ($additionalImage) {

                AdditionalImage::deleteImage($additionalImage->image);

                $additionalImage->delete();

            });

            Product::deleteImage($product->image);

            $product->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
