<?php

namespace App\Http\Controllers;

use App\Services\ZakekeService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ZakekeService $zakekeService;

    public function __construct(ZakekeService $zakekeService)
    {
        $this->zakekeService = $zakekeService;
    }

    public function getProducts(Request $request)
    {
        // Fetch the products from Zakeke API
        $products = $this->zakekeService->getProducts();

        // Return the products as JSON
        return response()->json($products);
    }
}


