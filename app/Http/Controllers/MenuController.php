<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    // All Categories
    public function index()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . 'api/categories');

        return view('pages.menu');
    }
}
