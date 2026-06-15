<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class PublicUpload
{
    public static function store(UploadedFile $file, string $directory): string
    {
        $directory = trim($directory, '/');
        $targetDirectory = public_path('storage/' . $directory);

        File::ensureDirectoryExists($targetDirectory);

        $fileName = $file->hashName();
        $file->move($targetDirectory, $fileName);

        return $directory . '/' . $fileName;
    }

    public static function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path('storage/' . ltrim($path, '/'));

        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }
}
