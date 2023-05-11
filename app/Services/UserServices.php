<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Client\ConnectionException;

class UserServices
{

    public $api_url;

    public function __construct()
    {
        $this->api_url = env('API_URL');
    }

    /**
     * Display the specified resource.
     */
    public function getUserById(string $id)
    {
        $url = $this->api_url . "Users/get-by-id";
        $token = session('token');
        $client = new Client();
        $options = [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            'verify'  => false
        ];
        //throws various exceptions:
        try {
            $result = $client->request('GET', $url . "?userId=$id", $options);
            $body = json_decode($result->getBody());
            return $body;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
}