<?php

namespace App\Http\Traits;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileStorageTrait
{
    /*
     * File Storage trait to store files in Amazon S3
     */

    public function storeFiles(Request $request, User $user)
    {
        $orgAcronym = $user->org->acronym;
        $projectName = $user->getCurrentProject()->name;
        $userId = $user->id;
        $disk = env('FILESYSTEM_DRIVER');
        $isZip = false;

        $storagePath = 'Files/Imports/'.$orgAcronym.'/'.$projectName.'/'.$userId.'/';
        // Check if a folder exists for the current Org
        if (!Storage::disk($disk)->exists($storagePath)) {
            Storage::makeDirectory($storagePath);
        }
        $returnRequest = $request;
        foreach ($request->all() as $key => $value) {
                if($request->hasFile($key)) {
                    $extension = $request->file($key)->extension();
                    if ($extension === 'zip') {
                        $isZip = true;
                        $storagePath = $storagePath . 'archive/';
                        Storage::makeDirectory($storagePath);
                    }
                    $fileName = $request->file($key)->getClientOriginalName();
                    $uploadedFile = $request->file($key);
                    $fullFilePath = $storagePath . $fileName;
                    Storage::disk($disk)->put($fullFilePath, file_get_contents($uploadedFile), "public");
                    $returnRequest = array_merge($returnRequest->all(), [$key => $fileName, 'fileLocation' => $fullFilePath, 'isZip' => $isZip]);
                }
        }
        return $returnRequest;
    }
}