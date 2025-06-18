<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadImageTrait
{
    public function UploadImage(UploadedFile $file, string $directoryName){
        
        $fileName = $directoryName.'/'.now()->format('d-m-Y') . '_' .uniqid().'.'. $file->getClientOriginalExtension();

        $file->move(public_path($directoryName),$fileName);

        return $fileName;
    }
}
