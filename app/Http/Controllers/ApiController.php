<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function product($id)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $url = 'api/products/' . $id;
        
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url);

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['products'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }

        return $data;
    }

    public function options_detail($ids)
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $url = 'api/options/detail/';

        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . $url, $ids);

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['options'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }

        return $data;
    }

    public function discount_check(Request $request)
    {
        $request->validate([
            'code' => 'required|alpha_num',
        ]);

        $postData['code'] = $request->code;

        $serverUrl  = env('SERVER_URL');
        $apiToken   = env('API_TOKEN');
        $url        = 'api/discount/check';
    
        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->post($serverUrl . $url, $postData);

        if($response['status'] == 'success'){
            $data['status'] = true;
            $data['discountDetail'] = $response['data'];
        }
        else{
            $data['status'] = false;
            $data['message'] = $response['message'];
        }

        return $data;
    }

    public function calculateDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|alpha_num',
        ]);

        $postData['code'] = $request->code;
        $postData['subTotal'] = $request->subTotal;

        $serverUrl  = env('SERVER_URL');
        $apiToken   = env('API_TOKEN');
        $url        = 'api/discount/calculate';
    
        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->post($serverUrl . $url, $postData);

        if($response['status'] == 'success'){
            session([
                'discountCode' => $request->code,
                'discountAmount' => $response['data']['discount_amount'],
            ]);
        }

        return $response;
    }
}
