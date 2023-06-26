<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class DeviceServices
{
    public $api_url;

    public function __construct()
    {
        $this->api_url = env('API_URL');
    }

    /**
     * Display the specified resource.
     */
    public function listAll()
    {
        $url = $this->api_url . "Devices/get-all?perPage=1000";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data->pagedList;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
    public function listAllComponents()
    {
        $url = $this->api_url . "Devices/get-all-components?perPage=1000";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data->pagedList;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
    public function getById($deviceId)
    {
        $url = $this->api_url . "Devices/$deviceId";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            return redirect()->back()->with('error', 'Not found');
        }
    }
    public function update($deviceId, Request $request)
    {
        $payload = (object)[
            'deviceId' => $request->deviceId,
            'name' => $request->name,
            'iotDeviceType' => $request->iotDeviceType == "None" ? null : (int)$request->iotDeviceType,
            'iotSensorType' => $request->iotSensorType == "None" ? null : (int)$request->iotSensorType,
            'iotConfigType' => (int)$request->iotConfigType,
            'iotSubDevices' => $request->iotSubDevices,
        ];

        $url = $this->api_url . "Devices/$deviceId";
        $token = session('token');
        $client = new Client();
        $options = [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            'json' => $payload,
            'verify'  => false
        ];
        //throws various exceptions:
        try {
            $result = $client->request('PATCH', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            dd($e);
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            dd($e);
            return redirect()->back()->with('error', 'Cannot Update');
        }
    }
    public function create(Request $request)
    {
        $payload = (object)[
            'deviceId' => $request->deviceId,
            'name' => $request->name,
            'iotDeviceType' => $request->iotDeviceType == "None" ? null : (int)$request->iotDeviceType,
            'iotSensorType' => $request->iotSensorType == "None" ? null : (int)$request->iotSensorType,
            'iotConfigType' => (int)$request->iotConfigType,
            'iotSubDevices' => $request->iotSubDevices,
        ];
        // dd($payload);
        $url = $this->api_url . "Devices/create";
        $token = session('token');
        $client = new Client();
        $options = [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            'json' => $payload,
            'verify'  => false
        ];
        //throws various exceptions:
        try {
            $result = $client->request('POST', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            dd($e);
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            dd($e);
            return redirect()->back()->with('error', 'Cannot Create');
        }
    }
    public function generateToken($deviceId)
    {
        $payload = (object)[
            'iotDeviceId' => $deviceId
        ];

        $url = $this->api_url . "Authentication/generate-token";
        $token = session('token');
        $client = new Client();
        $options = [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            'json' => $payload,
            'verify'  => false
        ];
        //throws various exceptions:
        try {
            $result = $client->request('POST', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            dd($e);
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            dd($e);
            return redirect()->back()->with('error', 'Cannot Generate Token');
        }
    }
    public function getDeviceTypes()
    {
        $url = $this->api_url . "Devices/list-device-types";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
    public function getSensorTypes()
    {
        $url = $this->api_url . "Devices/list-sensor-types";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
    public function getConfigTypes()
    {
        $url = $this->api_url . "Devices/list-config-types";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }
    public function dashboardSummary()
    {
        $url = $this->api_url . "Devices/get-summary";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }

    public function getTelemetry($deviceId, Request $request)
    {
        $url = $this->api_url . "Telemetries/get-all?iotDeviceId=$deviceId&startDate=$request->startDate&endDate=$request->endDate";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            dd($e);
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            dd($e);
            return redirect()->back()->with('error', 'Cannot fetch resources');
        }
    }

    public function getRelationships($deviceId)
    {
        $url = $this->api_url . "DeviceRelationships/get-all?iotDeviceId=$deviceId";
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
            $result = $client->request('GET', $url, $options);
            $body = json_decode($result->getBody());
            return $body->data;
        } catch (ConnectionException $e) {
            dd($e);
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            dd($e);
            return redirect()->back()->with('error', 'Cannot fetch resources');
        }
    }
}
