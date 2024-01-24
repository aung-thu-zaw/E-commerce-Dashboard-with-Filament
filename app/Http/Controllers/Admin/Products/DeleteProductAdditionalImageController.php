<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\AdditionalImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteProductAdditionalImageController extends Controller
{
    public function __invoke(AdditionalImage $additionalImage): Response
    {
        try {
            AdditionalImage::deleteImage($additionalImage->image);

            $additionalImage->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
