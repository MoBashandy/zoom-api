<?php
require_once './init.php';
// Initiate OAuth Flow
function get_oauth_step_1()
{
    //++++++++++++++++++++++++++++++++++++++++++++++++
    //++++++++++++++++++++++++++++++++++++++++++++++++
    $redirectURL = 'REDIRECT-URI';
    $authorizeURL = 'https://zoom.us/oauth/authorize';
    //++++++++++++++++++++++++++++++++++++++++++++++++
    $clientID = 'CLIENT-ID';
    //++++++++++++++++++++++++++++++++++++++++++++++++
    //++++++++++++++++++++++++++++++++++++++++++++++++

    $authURL['authURL'] = $authorizeURL . '?client_id=' . $clientID . '&redirect_uri=' . $redirectURL . '&response_type=code&scope=&state=xyz';
    header('Location: ' . $authURL['authURL']);
    exit();
}

// Exchange Authorization Code for Access Token
function get_oauth_step_2($code)
{
    $tokenURL = 'https://zoom.us/oauth/token';
    $redirectURL = 'REDIRECT-URI';
    $clientID = 'CLIENT-ID';
    $clientSecret = 'CLIENT-SECRET';

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $tokenURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectURL,
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic " . base64_encode($clientID . ':' . $clientSecret),
            "Content-Type: application/x-www-form-urlencoded",
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        die(json_encode([
            'status' => false,
            'errorCode' => 500,
            'errorMessage' => "cURL Error #: " . $err,
            'result' => null,
        ]));
    }

    $responseDecoded = json_decode($response, true);
    if (isset($responseDecoded['error'])) {
        die(json_encode([
            'status' => false,
            'errorCode' => $responseDecoded['error'],
            'errorMessage' => $responseDecoded['error_description'],
            'result' => null,
        ]));
    }

    return $responseDecoded;
}

// Create a Zoom Meeting
function create_a_zoom_meeting($accessToken)
{
    $requestBody = [
        'topic' => $_GET['topic'] ?? 'New Meeting',
        'type' => 2,
        'start_time' => $_GET['start_time'] . ':00Z' ?? date('Y-m-d\TH:i:s') . 'Z',
        'duration' => $_GET['duration'] ?? 30,
        'password' => $_GET['password'] ?? mt_rand(),
        'timezone' => 'UTC',
        // 'agenda' => $Req['agenda'] ?? 'General Meeting',
        'settings' => [
            'host_video' => false,
            'participant_video' => true,
            'join_before_host' => true,
            'mute_upon_entry' => true,
            'waiting_room' => false,
        ],
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.zoom.us/v2/users/me/meetings',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($requestBody),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $accessToken",
            'Content-Type: application/json',
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return [
            'success' => false,
            'msg' => 'cURL Error #:' . $err,
            'response' => null,
        ];
    } else {
        return [
            'success' => true,
            'msg' => 'success',
            'response' => json_decode($response, true),
        ];
    }
}

// Index function to initiate the process
function index()
{
    if (!isset($_GET['code'])) {
        get_oauth_step_1();
    } else {
        $getToken = get_oauth_step_2($_GET['code']);

        $get_zoom_details = create_a_zoom_meeting($getToken['access_token']);

        $link = $get_zoom_details['response']['join_url'];

        echo ($link);
    }
}

// Start the process
index();
