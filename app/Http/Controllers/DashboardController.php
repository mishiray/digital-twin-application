<?php

namespace App\Http\Controllers;

use App\Services\DeviceServices;
use Illuminate\Http\Request;
use App\Services\UserServices;

class DashboardController extends Controller
{
    public $api_url, $userService, $deviceService;

    public function __construct(UserServices $userService, DeviceServices $deviceService)
    {
        $this->api_url = env('API_URL');
        $this->userService = $userService;
        $this->deviceService = $deviceService;
    }

    function index()
    {
        $user = session('user');
        $summary = $this->deviceService->dashboardSummary();
        return view('admin.dashboard')->with('user', $user)->with('summary', $summary);
    }
}
