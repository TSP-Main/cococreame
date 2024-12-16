<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class MenuController extends Controller
{
    public function menu()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');

        $data = [
            'isClosed' => '',
            'msg' => '', 
            'opening' => '',
            'closing' => '',
            'code' => '',
            'menus' => []
        ];

        $schedule = is_restaurant_closed();

        if($schedule['status'] == 'error'){
            // restaurant is inactive or expired
            return view('pages.expiry');    
        }

        $data['isClosed']   = $schedule['isClosed'];
        $data['code']       = $schedule['code'];
        if($schedule['isClosed']){
            $data['msg']        = $schedule['message'];
            $data['schedule']   = $schedule;
            
            $data['opening']    = Carbon::createFromFormat('H:i:s', $schedule['todaySchedule']['opening_time'])->format('g:i A');
            $data['closing']    = Carbon::createFromFormat('H:i:s', $schedule['todaySchedule']['closing_time'])->format('g:i A');
            $data['code']       = $schedule['code'];
        }
        else{
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->get($serverUrl . 'api/products');

            if ($response->successful()) {       
                $responseData = $response->json();
                $data['menus'] = $responseData['data'];
            }
        }

        $data['currencySymbol'] = restaurant_detail()['restaurantDetail']['currency_symbol'];
        return view('pages.menu', $data);
    }
}
