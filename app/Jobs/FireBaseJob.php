<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class FireBaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $fcms;

    /**
     * Create a new job instance.
     */
    public function __construct($data = [], $fcms)
    {
        $this->data = $data;
        $this->fcms = $fcms;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendFireBaseNotification();
    }

    private function sendFireBaseNotification()
    {

//        $credentialsFilePath = base_path('public\json\fixil-f452d-7d522c190ec9.json');
        $credentialsFilePath = Http::get(asset('json/fixil-f452d-7d522c190ec9.json'));
        $client = new GoogleClient();
        try {
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->useApplicationDefaultCredentials();
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();
            $access_token = $token['access_token'] ?? null;
        } catch (Exception $e) {
            Log::error('Failed to get access token: ' . $e->getMessage());
        }

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fixil-f452d/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false); // Enable verbose output for debugging
        $results = [];
        foreach ($this->fcms as $fcm) {
            $data = [
                "message" => [
                    "token" => $fcm,
                    "notification" => [
                        "title" => __('messages.New Notification'),
                        "body" => $this->data[app()->getLocale()]['title'] ?? null,
                    ],
                    "data" => array_merge($this->data[app()->getLocale()], [
                        'title_ar' => $this->data['ar']['title'] ?? null,
                        'title_en' => $this->data['en']['title'] ?? null,
                    ], ['type' => $this->data['type']]),
                ],
            ];
            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $response = curl_exec($ch);
            $err = curl_error($ch);

            if ($err) {
                $results[] = [
                    'token' => $fcm,
                    'error' => 'Curl Error: ' . $err
                ];
            } else {
                $results[] = [
                    'token' => $fcm,
                    'response' => json_decode($response, true)
                ];
            }
        }
        curl_close($ch);
        Log::error('Notifications have been sent');
    }
}
