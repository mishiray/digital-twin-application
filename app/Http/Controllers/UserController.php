<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public $api_url, $bearer_token, $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
        $this->api_url = env('API_URL');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function show()
    {
        $user = session('user');
        return view('admin.profile')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    public function login(Request $request)
    {
        $payload = (object)[
            'userName' => $request->email,
            'password' => $request->password
        ];

        $url = $this->api_url . "Authentication/login";
        $client = new Client();
        $options = [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => $payload,
            'verify'  => false
        ];
        //throws various exceptions:
        try {
            $result = $client->request('POST', $url, $options);
            $body = json_decode($result->getBody());
            session(['user_id' => $body->data->userId]);
            session(['token' => $body->data->token]);
            $user = $this->userService->getUserById(session('user_id'));
            session(['user' => $user->data]);
            return redirect('dashboard');
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', "Unable to connect to middleware");
        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $error_array = implode(',', $response->errors[0]->errorMessages);
            return redirect()->back()->with('error', $error_array);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
