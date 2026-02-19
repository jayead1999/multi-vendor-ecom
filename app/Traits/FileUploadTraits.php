<?php

 namespace App\Traits;

use Illuminate\Http\File as HttpFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


trait FileUploadTraits
{
    public function fileUpload(UploadedFile $file,?string $oldPath = null ,?string $path = 'uploads'): ?string
    {
        if (! $file->isValid()) {
            return null;
        }

        if($oldPath && File::exists(public_path($oldPath))){
            File::delete(public_path($oldPath));
        }
        $folderPath = public_path($path);

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $fileName);

        return $path . '/' . $fileName;
    }
}
