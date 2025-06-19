<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadImageTrait
{
    public function UploadImage(UploadedFile $file, string $directoryName){
        
        $fileName = now()->format('d-m-Y') . '_' .uniqid().'.'. $file->getClientOriginalExtension();

        $path = $file->storeAs($directoryName, $fileName, 'public');

        return $path;
    }
}
