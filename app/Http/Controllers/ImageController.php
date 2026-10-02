<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($path)
    {
        $path = '/images/' . $path;
        if (!Storage::exists($path)) abort(404);

        return response(Storage::get($path), 200)
            ->header('Content-Type', Storage::mimeType($path));
    }
}
