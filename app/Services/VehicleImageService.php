<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VehicleImageService
{
    public function store(?UploadedFile $image, string $directory, ?string $currentPath = null): ?string
    {
        if (! $image) {
            return $currentPath;
        }

        $this->delete($currentPath);

        return 'storage/'.$image->store($directory, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
