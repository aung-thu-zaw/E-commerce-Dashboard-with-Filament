<?php

namespace App\Http\Resources\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "image" => $this->image,
            "name" => $this->name,
            "slug" => $this->slug,
            "ingredients" => $this->ingredients,
            "description" => $this->description,
            "qty" => $this->qty,
            "is_available" => $this->is_available,
            "base_price" => $this->base_price,
            "discount_price" => $this->discount_price,
            "discount_end_time" => $this->discount_end_time,
            "status" => $this->status,
            "additional_images" => AdditionalImageResource::collection($this->additionalImages),
            "addons" => AddonResource::collection($this->addons)
        ];
    }
}
