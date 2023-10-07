<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PathController extends Controller
{
    public function getFilePath1(Request $request)
    {
        // Retrieve the file from the request
        $file = $request->file('file');

        // Check if the file was uploaded successfully
        if ($file->isValid()) {
            // Store the file in a desired location (e.g., 'storage/app/files/')
            $filePath = $file->store('files');

            // Get the absolute path of the stored file
            $path = storage_path('app/' . $filePath);

            return response()->json(['path' => $path]);
        } else {
            return response()->json(['error' => 'File upload failed'], 400);
        }
    }








    public function getFilePath2(Request $request)
    {
        // Retrieve the file from the request
        $file = $request->file('file');

        // Check if the file was uploaded successfully
        if ($file->isValid()) {
            // Get the original file name
            $fileName = $file->getClientOriginalName();

            // Store the file in a desired location (e.g., 'storage/app/files/')
            $filePath = $file->storeAs('files', $fileName);

            // Get the absolute path of the stored file
            $path = storage_path('app/' . $filePath);

            return response()->json(['path' => $path]);
        } else {
            return response()->json(['error' => 'File upload failed'], 400);
        }
    }





    public function getFilePath(Request $request)
    {
        // Retrieve the file from the request
        $file = $request->file('file');

        // Check if the file was uploaded successfully
        if ($file->isValid()) {
            // Get the original file name
            $fileName = $file->getClientOriginalName();

            // Store the file in a desired location (e.g., 'storage/app/files/')
            $filePath = $file->storeAs('files', $fileName);

            // Get the absolute path of the stored file
            $path = storage_path('app/' . $filePath);

            // Append "file:///" before the path
            $pathWithProtocol = "file:///" . $path;

            return response()->json(['path' => $pathWithProtocol]);
        } else {
            return response()->json(['error' => 'File upload failed'], 400);
        }
    }

}

