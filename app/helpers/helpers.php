<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;


function is_restaurant_closed()
{
    $serverUrl = env('SERVER_URL');
    $apiToken = env('API_TOKEN');

    $sresponseData = Http::withHeaders([
        'Authorization' => $apiToken,
    ])->get($serverUrl . 'api/schedule');

    if ($sresponseData['status'] == 'success') {
        $scheduleData = $sresponseData['data']['schedule'];
        $timezone = $sresponseData['data']['timezone'][0];

        $currentTime = Carbon::now($timezone);

        // Get today and yesterday's schedule
        $todayName = $currentTime->format('l');
        $yesterdayName = $currentTime->copy()->subDay()->format('l');
        
        $todaySchedule = collect($scheduleData)->firstWhere('day', $todayName);
        $yesterdaySchedule = collect($scheduleData)->firstWhere('day', $yesterdayName);

        // If it's past midnight and within yesterday's closing time, use yesterday's schedule
        if ($yesterdaySchedule && !$yesterdaySchedule['is_closed'] && 
            $yesterdaySchedule['closing_time'] && 
            $currentTime->format('H:i:s') < $yesterdaySchedule['closing_time']) {

            $openingTime = Carbon::createFromFormat('H:i:s', $yesterdaySchedule['opening_time'], $timezone)
                ->setDate($currentTime->year, $currentTime->month, $currentTime->day - 1);

            $closingTime = Carbon::createFromFormat('H:i:s', $yesterdaySchedule['closing_time'], $timezone)
                ->setDate($currentTime->year, $currentTime->month, $currentTime->day);

        } else {
            // Use today's schedule as usual
            if ($todaySchedule['is_closed'] || !$todaySchedule['opening_time'] || !$todaySchedule['closing_time']) {
                return [
                    'isClosed' => true,
                    'message' => 'Restaurant is closed today',
                    'code' => '001',
                    'todaySchedule' => $todaySchedule,
                    'status' => 'success'
                ];
            }

            $openingTime = Carbon::createFromFormat('H:i:s', $todaySchedule['opening_time'], $timezone)
                ->setDate($currentTime->year, $currentTime->month, $currentTime->day);
            $closingTime = Carbon::createFromFormat('H:i:s', $todaySchedule['closing_time'], $timezone)
                ->setDate($currentTime->year, $currentTime->month, $currentTime->day);

            // Adjust closing time if it’s past midnight
            if ($closingTime->lessThan($openingTime)) {
                $closingTime->addDay();
            }
        }

        // Check if the restaurant is currently open
        $isClosed = !$currentTime->between($openingTime, $closingTime);
        return [
            'isClosed' => $isClosed,
            'message' => $isClosed ? 'Restaurant is closed at this time' : 'Restaurant is open',
            'code' => $isClosed ? '002' : '000',
            'todaySchedule' => $todaySchedule,
            'status' => 'success'
        ];
    }
    else{
        return $sresponseData;
    }
    
}

function restaurant_detail()
{
    $serverUrl = env('SERVER_URL');
    $apiToken = env('API_TOKEN');
    
    $response = Http::withHeaders([
        'Authorization' => $apiToken,
    ])->get($serverUrl . 'api/restaurant_detail');

    if($response['status'] == 'success'){
        $data['response'] = true;
        $data['restaurantDetail'] = $response['data'];
    }
    else{
        $data['response'] = false;
    }
    
    return $data;
}