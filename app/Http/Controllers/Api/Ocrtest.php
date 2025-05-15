<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Ocrtest extends Controller
{
    public function ocrWithApi(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $file = $request->file('image');

        $response = Http::attach(
            'file',
            fopen($file->getPathname(), 'r'),
            $file->getClientOriginalName()
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => 'K87175812688957', // Ganti dengan API key dari OCR.Space
          
        ]);

        $result = $response->json();

        return response()->json([
            'text' =>  $result
        ]);
    }
}
