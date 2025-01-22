<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function getProducts()
    {
        try {
            // Check if the token is cached
            if (Cache::has('zakeke_token')) {
                $token = Cache::get('zakeke_token');
            } else {
                // Fetch the token from ZakekeAuthController API
                $client = new Client();
                $response = $client->request('GET', url('/api/zakeke/token'));
                $tokenData = json_decode($response->getBody(), true);

                if (!isset($tokenData['token'])) {
                    return response()->json(['error' => 'Unable to authenticate with Zakeke API'], 500);
                }

                $token = $tokenData['token'];

                // Cache the token for 1 hour
                Cache::put('zakeke_token', $token, now()->addHour());
            }

            // Fetch products from Zakeke
            $client = new Client();
            $response = $client->request('GET', env('ZAKEKE_API_BASE_URL') . '/v2/products', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            $products = json_decode($response->getBody(), true);

            return response()->json($products);

        } catch (GuzzleException $e) {
            return response()->json(['error' => 'Guzzle error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
