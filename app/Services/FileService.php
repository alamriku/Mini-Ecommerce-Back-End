<?php


namespace App\Services;





use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile($data)
    {
        $file = $data->file('image');
        return Storage::disk('public')->putFile('products/photos', $file);
    }

    public function removeFile($filePath)
    {
        Storage::disk('public')->delete($filePath);
    }
}
