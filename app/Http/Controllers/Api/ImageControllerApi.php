<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;
use App\Models\SuratKeluarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageControllerApi extends Controller
{
    public function getImage(string $filename)
    {
        $path = 'kk/' . $filename;
        if (!Storage::disk(name: 'private')->exists(path: $path)) {
            Log::error("File not found: " . $path);
            abort(code: 404);
        }
        $file = Storage::disk(name: 'private')->get($path);
        $type = Storage::disk(name: 'private')->mimeType($path);
        return response($file, 200)->header('Content-Type', $type);
    }
}
