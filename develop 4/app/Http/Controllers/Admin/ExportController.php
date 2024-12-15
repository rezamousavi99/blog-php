<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * List all export files.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get all files in the 'exports' directory
        $files = Storage::files('exports');

        // Transform the list of files into a more readable format (only the file name)
        $fileList = collect($files)->map(function ($file) {
            return basename($file); // Extract just the filename
        });

        return response()->json([
            'files' => $fileList
        ]);
    }

    /**
     * Download the selected file.
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function download($filename)
    {
        $filePath = 'exports/' . $filename;

        // Check if the file exists
        if (!Storage::exists($filePath)) {
            return response()->json([
                'error' => 'File not found.'
            ], 404);
        }

        // Stream the file as a response for download
        return Storage::download($filePath);
    }
}
