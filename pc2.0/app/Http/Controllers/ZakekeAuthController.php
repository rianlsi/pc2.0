<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ZakekeAuthController extends Controller
{
    public function getBearerToken()
    {
        try {
            $client = new Client();

            // request to get the bearer token
            $response = $client->request('POST', rtrim(env('ZAKEKE_API_BASE_URL'), '/') . '/token', [
                'auth' => [
                    env('ZAKEKE_CLIENT_ID'),    // Username (Client ID)
                    env('ZAKEKE_CLIENT_SECRET') // Password (Client Secret)
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            // decode the response
            $data = json_decode($response->getBody(), true);

            // return the access token
            return response()->json(['token' => $data['access_token']]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => 'Guzzle error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed: ' . $e->getMessage()], 500);
        }
    }
}
