<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;

trait ImageUpload
{
    public function createImage(UploadedFile $image, string $folderName): ?string
    {
        $originalName = $image->getClientOriginalName();

        $fileName = time().'-'.$originalName;

        $image->storeAs($folderName, $fileName);

        return $fileName;
    }

    public function updateImage(UploadedFile $image, ?string $oldImage, string $folderName): string
    {

        if (is_string($oldImage) && ! empty($oldImage) && file_exists(storage_path("app/public/$folderName/".pathinfo($oldImage, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/$folderName/".pathinfo($oldImage, PATHINFO_BASENAME)));
        }

        $originalName = $image->getClientOriginalName();

        $fileName = time().'-'.$originalName;

        $image->storeAs($folderName, $fileName);

        return $fileName;
    }
}
