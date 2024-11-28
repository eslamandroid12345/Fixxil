<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTapController;
use App\Http\Controllers\Api\V1\App\Social\SocialController;


use Google\Service\Drive;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Google\Client as GoogleClient;

Route::get('/echo', function () {


    // Using print (returns 1, can be stored in a variable)
    $resultPrint = print(2 / 10);  // This works because print returns a value (1)

    echo "<br>Result of print: " . $resultPrint;  // Outputs the return value of print, which is 1
});


Route::get('/testnotification', function () {

//     $fcm = "e8ZzIoEmQ3GN_DXZMrb7v6:APA91bFxc3G-AsWPI013ct4A8DPcTD-PRhdRNP9TDUh9XT1vQ1GKbOWs9tqRC4s1JwcapTVdUxPNk9KdbLTCC0pRUsHuQdXVDdR7kzuvMHfUz5gJ4yTqIuV3DOG6w1pPY4RdTOEmEWU9";
    $fcm = "eTPu2GPNQOmmlroyGdcwlW:APA91bHK0nW1oGr61MQq3Eo-_xAAJcMDe98YUmc28o8VO6MDtzlfKaDtrcMwNK-r89bI0TstqwkTlkE5Ga3MNzq-D0hFpC_wBRRBPKiD7_PAzqa0eZan2f2Dl4ecLWXKDYBNJmNXTi4n";
    $title = "اشعار جديد";
    $description = "تيست تيست تيست";

    $credentialsFilePath = "json/fixil-f452d-7d522c190ec9.json";
//     $credentialsFilePath = base_path('public/json/fixil-f452d-abac09cdcbb3.json'); // local
//    $credentialsFilePath = Http::get(asset('json/fixil-f452d-abac09cdcbb3.json'));
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $client->refreshTokenWithAssertion();
    $token = $client->getAccessToken();

    $access_token = $token['access_token'];

    $headers = [
        "Authorization: Bearer $access_token",
        'Content-Type: application/json'
    ];

    $data = [
        "message" => [
            "token" => $fcm,
            "notification" => [
                "title" => $title,
                "body" => $description,
            ],
        ]
    ];
    $payload = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fixil-f452d/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return response()->json([
            'message' => 'Curl Error: ' . $err
        ], 500);
    } else {
        return response()->json([
            'message' => 'Notification has been sent',
            'response' => json_decode($response, true)
        ]);
    }
})->name('testnotification2');

//Route::get('/getform', function () {
//    return view('hyperpay');
//})->name('getform');

//Route::get('/getformtap', function () {
//    return view('indextap');
//})->name('getformtap');
//
Route::get('/testdate', function () {
    $governorates = \App\Models\Governorate::all();
    foreach($governorates as $governorate)
    {
        $governorate->name_ar = trim($governorate->name_ar);
        $governorate->name_en = trim($governorate->name_en);
        $governorate->sort_ar = mb_substr(trim($governorate->name_ar), 0, 1);
        $governorate->sort_en = mb_substr(trim($governorate->name_en), 0, 1);
        $governorate->save();
    }
    return "done";
})->name('testdate');

Route::get('/testcities', function () {
    $cities = \App\Models\City::all();
    foreach($cities as $city)
    {
        $city->name_ar = trim($city->name_ar);
        $city->name_en = trim($city->name_en);
        $city->sort_ar = mb_substr(trim($city->name_ar), 0, 1);
        $city->sort_en = mb_substr(trim($city->name_en), 0, 1);
        $city->save();
    }
    return "done";
})->name('testcities');

Route::get('/testzones', function () {
    $zones = \App\Models\Zone::all();
    foreach($zones as $zone)
    {
        $zone->name_ar = trim($zone->name_ar);
        $zone->name_en = trim($zone->name_en);
        $zone->sort_ar = mb_substr(trim($zone->name_ar), 0, 1);
        $zone->sort_en = mb_substr(trim($zone->name_en), 0, 1);
        $zone->save();
    }
    return "done";
})->name('testzones');




//Route::get('/testnotification', function () {
//
//    $fcms = [
//        "eTPu2GPNQOmmlroyGdcwlW:APA91bHK0nW1oGr61MQq3Eo-_xAAJcMDe98YUmc28o8VO6MDtzlfKaDtrcMwNK-r89bI0TstqwkTlkE5Ga3MNzq-D0hFpC_wBRRBPKiD7_PAzqa0eZan2f2Dl4ecLWXKDYBNJmNXTi4n",
//        "eTPu2GPNQOmmlroyGdcwlW:APA91bHK0nW1oGr61MQq3Eo-_xAAJcMDe98YUmc28o8VO6MDtzlfKaDtrcMwNK-r89bI0TstqwkTlkE5Ga3MNzq-D0hFpC_wBRRBPKiD7_PAzqa0eZan2f2Dl4ecLWXKDYBNJmNXTi4n",
//    ];
//
//    $title = "اشعار جديد";
//    $description = "تيست تيست تيست";
//    $credentialsFilePath = "json/fixil-f452d-abac09cdcbb3.json";
////    $credentialsFilePath = Http::get(asset('json/fixil-f452d-abac09cdcbb3.json'));
//    $client = new GoogleClient();
//    try {
//        $client->setAuthConfig($credentialsFilePath);
//        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
//        $client->useApplicationDefaultCredentials();
//        $client->fetchAccessTokenWithAssertion();
//        $token = $client->getAccessToken();
//        $access_token = $token['access_token'];
//    } catch (Exception $e) {
//        return response()->json([
//            'message' => 'Failed to get access token: ' . $e->getMessage()
//        ], 500);
//    }
//
//    $headers = [
//        "Authorization: Bearer $access_token",
//        'Content-Type: application/json'
//    ];
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fixil-f452d/messages:send');
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
//
//    $results = [];
//    foreach ($fcms as $fcm) {
//        $data = [
//            "message" => [
//                "token" => $fcm,
//                "notification" => [
//                    "title" => $title,
//                    "body" => $description,
//                ],
//                "data" => [
//                    "title" => $title,
//                    "body" => $description,
//                ]
//            ]
//        ];
//        $payload = json_encode($data);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//
//        $response = curl_exec($ch);
//        $err = curl_error($ch);
//
//        if ($err) {
//            $results[] = [
//                'token' => $fcm,
//                'error' => 'Curl Error: ' . $err
//            ];
//        } else {
//            $results[] = [
//                'token' => $fcm,
//                'response' => json_decode($response, true)
//            ];
//        }
//    }
//    curl_close($ch);
//
//    return response()->json([
//        'message' => 'Notifications have been sent',
//        'results' => $results
//    ]);
//})->name('testnotification');

//Route::get('/testnotification12', function () {
//
//    $fcms = [
//        "e8ZzIoEmQ3GN_DXZMrb7v6:APA91bFxc3G-AsWPI013ct4A8DPcTD-PRhdRNP9TDUh9XT1vQ1GKbOWs9tqRC4s1JwcapTVdUxPNk9KdbLTCC0pRUsHuQdXVDdR7kzuvMHfUz5gJ4yTqIuV3DOG6w1pPY4RdTOEmEWU9",
//        "e8ZzIoEmQ3GN_DXZMrb7v6:APA91bFxc3G-AsWPI013ct4A8DPcTD-PRhdRNP9TDUh9XT1vQ1GKbOWs9tqRC4s1JwcapTVdUxPNk9KdbLTCC0pRUsHuQdXVDdR7kzuvMHfUz5gJ4yTqIuV3DOG6w1pPY4RdTOEmEWU9",
//    ];
//
//    $title = "اشعار جديد";
//    $description = "تيست تيست تيست";
//    $credentialsFilePath = "json/fixil-f452d-abac09cdcbb3.json";
////    $credentialsFilePath = Http::get(asset('json/fixil-f452d-abac09cdcbb3.json'));
//    $client = new GoogleClient();
//    try
//    {
//        $client->setAuthConfig($credentialsFilePath);
//        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
//        $client->useApplicationDefaultCredentials();
//        $client->fetchAccessTokenWithAssertion();
//        $token = $client->getAccessToken();
//        $access_token = $token['access_token'];
//    }
//    catch (Exception $e)
//    {
//        return response()->json(['message' => 'Failed to get access token: ' . $e->getMessage()], 500);
//    }
//
//    $headers = [
//        "Authorization: Bearer $access_token",
//        'Content-Type: application/json'
//    ];
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fixil-f452d/messages:send');
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
//
//    $results = [];
//    foreach ($fcms as $fcm) {
//        $data = [
//            "message" => [
//                "token" => $fcm,
//                "notification" => [
//                    "title" => $title,
//                    "body" => $description,
//                ],
//                "data" => [
//                    "title" => $title,
//                    "body" => $description,
//                ]
//            ]
//        ];
//        $payload = json_encode($data);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//
//        $response = curl_exec($ch);
//        $err = curl_error($ch);
//
//        if ($err)
//        {
//            $results[] = [
//                            'token' => $fcm,
//                            'error' => 'Curl Error: ' . $err
//                        ];
//        }
//        else
//        {
//            $results[] = [
//                            'token' => $fcm,
//                            'response' => json_decode($response, true)
//                        ];
//        }
//    }
//    curl_close($ch);
//
//    return response()->json([
//                                'message' => 'Notifications have been sent',
//                                'results' => $results
//                            ]);
//})->name('testnotification');


//Route::get('/testnotification2', function () {
//
//    $fcm = "e8ZzIoEmQ3GN_DXZMrb7v6:APA91bFxc3G-AsWPI013ct4A8DPcTD-PRhdRNP9TDUh9XT1vQ1GKbOWs9tqRC4s1JwcapTVdUxPNk9KdbLTCC0pRUsHuQdXVDdR7kzuvMHfUz5gJ4yTqIuV3DOG6w1pPY4RdTOEmEWU9";
//
//    $title = "اشعار جديد";
//    $description = "تيست تيست تيست";
//
//    // $credentialsFilePath = "json/fixil-f452d-abac09cdcbb3.json"; // local
//    $credentialsFilePath = base_path('public/json/fixil-f452d-abac09cdcbb3.json');
//    // return $credentialsFilePath;
////    $credentialsFilePath = Http::get(asset('json/fixil-f452d-abac09cdcbb3.json')); //server
//    $client = new GoogleClient();
//    $client->setAuthConfig($credentialsFilePath);
//    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
//    $client->refreshTokenWithAssertion();
//    $token = $client->getAccessToken();
//
//    $access_token = $token['access_token'];
//
//    $headers = [
//        "Authorization: Bearer $access_token",
//        'Content-Type: application/json'
//    ];
//
//    $data = [
//        "message" => [
//            "token" => $fcm,
//            "notification" => [
//                "title" => $title,
//                "body" => $description,
//            ],
//            "data" => [
//                        'screen' => "test",
//                        "click_action" => "FLUTTER_NOTIFICATION_CLICK"
//                    ],
//        ]
//    ];
//    $payload = json_encode($data);
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fixil-f452d/messages:send');
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
//    $response = curl_exec($ch);
//    $err = curl_error($ch);
//    curl_close($ch);
//
//    if ($err) {
//        return response()->json([
//            'message' => 'Curl Error: ' . $err
//        ], 500);
//    } else {
//        return response()->json([
//            'message' => 'Notification has been sent',
//            'response' => json_decode($response, true)
//        ]);
//    }
//})->name('testnotification2');


//Route::get('/check_out_hyper_pay/{type}/{id}', [TransactionController::class, 'tap_checkout'])->name('hyper_pay_checker');
//Route::get('/check_out_hyper_pay', [TransactionController::class, 'hyper_checkout'])->name('check_out_hyper_pay');

//Route::get('/payment_gateways/{method}', [TransactionTapController::class, 'paymentGateways'])->name('payment_gateways');
//Route::get('/check_out_tap_pay', [TransactionTapController::class, 'tap_checkout'])->name('check_out_tap_pay');
//// Route::get('/check_out_tap_pay/{ $type }/{ $id }', [TransactionController::class, 'tap_checkout_checker'])->name('check_out_tap_pay_checker');
//Route::get('/callback_tap_pay', [TransactionTapController::class, 'tap_callback'])->name('callback_tap_pay');
//Route::any('/post_callback_tap_pay', [TransactionTapController::class, 'save_callback'])->name('post_callback_tap_pay');


//Route::group(['prefix' => '/login', 'controller' => SocialController::class], function () {
//    Route::get('{provider}','redirect');
//    Route::get('{provider}/callback','Callback');
//});

//Route::get('/social', function () {
//    return view('social');
//})->name('social');
//
Route::get('/', function () {
    return view('welcome');
})->name('home');

//Route::get('/test', function () {
//    $id=3;
//    $user = App\Models\User::find(11);
////    foreach($users as $user)
////    {
//        $sum = 0;
//        foreach($user->questionRateProviders as $item)
//        {
//            $sum += $item->rate;
//        }
//        $user->avarage = $sum/$user->questionRateProviderCount();
////    }
//    return $user;
//});
//Route::get('/test2', function () {
//    $governorates = DB::table('governorates')
//        ->select('governorates.id', 'governorates.name_en')
//        ->selectRaw('GROUP_CONCAT(cities.name_en) AS city_names')
//        ->selectRaw('GROUP_CONCAT(cities.id) AS city_ids')
//        ->join('cities', 'governorates.id', '=', 'cities.governorate_id')
//        ->join('city_user', 'cities.id', '=', 'city_user.city_id')
//        ->where('city_user.user_id', 13)
//        ->groupBy('governorates.id', 'governorates.name_en')
//        ->get();
//    // Process the result to format cities as arrays
//    $result = $governorates->map(function ($item) {
//        $cityNames = explode(',', $item->city_names);
//        $cityIds = explode(',', $item->city_ids);
//        $cities = [];
//        // Create array of city objects with name and id
//        foreach ($cityNames as $index => $cityName) {
//            $cityId = $cityIds[$index];
//            $cities[] = [
//                'name' => $cityName,
//                'id' => $cityId,
//            ];
//        }
//        // Replace city_names and city_ids with formatted cities array
//        unset($item->city_names);
//        unset($item->city_ids);
//        $item->cities = $cities;
//
//        return $item;
//    });
//    return $governorates;

//    $language = app()->getLocale();
//    $cityNameColumn = ($language === 'ar') ? 'cities.name_ar' : 'cities.name_en';
//
//    $governorates = DB::table('governorates')
//        ->select(
//            'governorates.id',
//            'governorates.name_en as governorate_name_en',
//            'governorates.name_ar as governorate_name_ar'
//        )
//        ->selectRaw("GROUP_CONCAT($cityNameColumn) AS city_names")
//        ->selectRaw('GROUP_CONCAT(cities.id) AS city_ids')
//        ->join('cities', 'governorates.id', '=', 'cities.governorate_id')
//        ->join('city_user', 'cities.id', '=', 'city_user.city_id')
//        ->where('city_user.user_id', 13)
//        ->groupBy('governorates.id', 'governorates.name_en', 'governorates.name_ar')
//        ->get();
//
//    // Process the result to format cities as arrays with the correct language
//    $result = $governorates->map(function ($item) use ($language) {
//        $cityNames = explode(',', $item->city_names);
//        $cityIds = explode(',', $item->city_ids);
//        $cities = [];
//
//        // Create array of city objects with name and id in the specified language
//        foreach ($cityNames as $index => $cityName) {
//            $cityId = $cityIds[$index];
//            $cities[] = [
//                'name' => $cityName,
//                'id' => $cityId,
//            ];
//        }
//
//
//
//        // Set the governorate name based on the current language
//        $item->governorate_name = ($language === 'ar') ? $item->governorate_name_ar : $item->governorate_name_en;
//
//        // Unset language-specific governorate name attributes
//        unset($item->governorate_name_en);
//        unset($item->governorate_name_ar);
//
//        // Replace city_names and city_ids with formatted cities array
//        unset($item->city_names);
//        unset($item->city_ids);
//        $item->cities = $cities;
//
//        return $item;
//    });
//
//    return $result;
//
//});





