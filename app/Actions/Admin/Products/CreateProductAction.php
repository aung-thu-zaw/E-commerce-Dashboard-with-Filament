<?php

namespace App\Actions\Admin\Products;

use App\Http\Traits\ImageUpload;
use App\Models\AdditionalImage;
use App\Models\Addon;
use App\Models\Product;

class CreateProductAction
{
    use ImageUpload;

    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): Product
    {
        $image = isset($data['image']) ? $this->createImage($data['image'], 'products') : null;

        $product = Product::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'ingredients' => $data['ingredients'],
            'description' => $data['description'],
            'qty' => $data['qty'],
            'is_available' => filter_var($data['is_available'], FILTER_VALIDATE_BOOLEAN),
            'base_price' => $data['base_price'],
            'discount_price' => $data['discount_price'],
            'discount_end_time' => $data['discount_end_time'],
            'status' => $data['status'],
            'image' => $image,
        ]);

        if (isset($data['addons'])) {
            foreach ($data['addons'] as $addon) {
                Addon::create([
                    'product_id' => $product->id,
                    'name' => $addon['name'],
                    'additional_price' => $addon['additional_price'],
                ]);
            }
        }

        if (isset($data['additional_images'])) {
            foreach ($data['additional_images'] as $additionalImage) {

                $originalName = $additionalImage->getClientOriginalName();

                $fileName = time().'-'.$originalName;

                $additionalImage->storeAs('products', $fileName);

                AdditionalImage::create(['product_id' => $product->id, 'image' => $fileName]);
            }
        }

        return $product;
    }
}
