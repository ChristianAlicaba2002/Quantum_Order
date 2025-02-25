<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function ensureDefaultImageExists(): void
    {
        Storage::disk('public')->makeDirectory('images', 0755, true, true);

        if (!Storage::disk('public')->exists('images/default.jpg')) {
            $defaultSource = resource_path('images/default.jpg');
            if (file_exists($defaultSource)) {
                Storage::disk('public')->put(
                    'images/default.jpg', 
                    file_get_contents($defaultSource)
                );
            }
        }
    }

    public function storeUserImage(?UploadedFile $image): string
    {
        if (!$image) {
            return 'default.jpg';
        }

        $imageName = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('images', $image, $imageName);
        
        return $imageName;
    }
} 