<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZakekeService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ZAKEKE_API_BASE_URL'); // Load the base URL from .env file
    }

    public function getProducts()
    {
        // Make an API request to fetch products from Zakeke
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('ZAKEKE_API_KEY') // Add API key in header
        ])->get($this->baseUrl . '/products'); // Adjust the endpoint as needed

        return $response->json(); // Return the JSON data of products
    }
}
