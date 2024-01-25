<?php

namespace App\Actions\Admin\Products;

use App\Http\Traits\ImageUpload;
use App\Models\AdditionalImage;
use App\Models\Addon;
use App\Models\Product;

class UpdateProductAction
{
    use ImageUpload;

    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, Product $product): Product
    {
        $image = isset($data['image']) && ! is_string($data['image']) ? $this->updateImage($data['image'], $product->image, 'products') : $product->image;

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'ingredients' => $data['ingredients'],
            'description' => $data['description'],
            'qty' => $data['qty'],
            'is_available' => filter_var($data['is_available'], FILTER_VALIDATE_BOOLEAN),
            'base_price' => $data['base_price'],
            'discount_price' => $data['discount_price'] ?? null,
            'discount_end_time' => $data['discount_end_time'] ?? null,
            'status' => $data['status'],
            'image' => $image,
        ]);

        if (isset($data['addons'])) {
            $existingAddons = Addon::where('product_id', $product->id)->get();

            if (empty($data['addons'])) {
                foreach ($existingAddons as $existingAddon) {
                    $existingAddon->delete();
                }
            }

            foreach ($existingAddons as $existingAddon) {
                foreach ($data['addons'] as $addon) {
                    if ($existingAddon->name !== $addon['name']) {
                        $existingAddon->delete();
                    }
                }
            }

            foreach ($data['addons'] as $addon) {
                Addon::firstOrCreate([
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
