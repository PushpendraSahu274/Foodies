<?php

namespace App\Traits;

// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Cloudinary;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

trait UploadImageTrait
{

    public function UploadImage(UploadedFile $file, string $directoryName)
    {

        $fileName = now()->format('d-m-Y') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($directoryName, $fileName, 'public');

        return $path;
    }


    public function uploadToCloudinary(UploadedFile $file, string $folder)
    {
        try {
            $cloudinary = app(Cloudinary::class);

            $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'image',
                'transformation' =>
                [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill', // or 'fit', 'thumb'
                    'gravity' => 'face' // optional: for smart cropping
                ]
            ]);

            return $upload['public_id'];
        } catch (\Exception $e) {
            abort(500, 'Internal server error: ' . $e->getMessage());
        }
    }

    public function isCloudinaryResourceExists(String $publicId)
    {
        try {
            $cloudinary = app(Cloudinary::class);
            $exists = $cloudinary->adminApi()->asset($publicId);
            // if no error means resource exists.

            return $exists;
        } catch (\Cloudinary\Api\Exception\NotFound $e) {
            //resource not found
            return false;
        } catch (\Exception $e) {
            Log::error('Cloudinary check failed. ' . $e->getMessage());
            return false;
        }
    }

    public function deleteResourceFromCloudinary(String $publicId)
    {
        $cloudinary = app(Cloudinary::class);

        try {
            $deleteResource = $cloudinary->uploadApi()->destroy($publicId);

            return $deleteResource['result'] = 'ok';
        } catch (\Exception $e) {
            Log::warning('Cloudinary delete resource : ' . $e->getMessage());
            return response()->json([
                'sucess' => false,
                'message' => 'Error Occurec while deleting resource ' . $e->getMessage(),
            ]);
        }
    }

    public function getCloudinaryResourceUrl(string $publicId, array $transformation = []): ?string
    {
        try {
            $cloudinary = app(Cloudinary::class);

            return $cloudinary->image($publicId)
                ->secure(true)
                ->toUrl();
        } catch (\Exception $e) {
            Log::warning('Failed to generate Cloudinary URL: ' . $e->getMessage());
            return null;
        }
    }

}
