<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StorageController extends Controller
{
    public function show(string $path): BinaryFileResponse
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            abort(404);
        }

        $mime = mime_content_type($fullPath);
        $allowedMimes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
            'image/bmp', 'image/ico', 'application/pdf',
            'text/css', 'text/javascript', 'application/javascript',
        ];

        if (!in_array($mime, $allowedMimes)) {
            abort(403);
        }

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
