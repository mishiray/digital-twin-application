<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDeviceRequest;
use App\Services\DeviceServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use stdClass;

class DeviceController extends Controller
{
    public $api_url, $userService, $deviceService, $user;

    public function __construct(UserServices $userService, DeviceServices $deviceService)
    {
        $this->api_url = env('API_URL');
        $this->userService = $userService;
        $this->deviceService = $deviceService;
    }

    public function index()
    {
        $device_list = $this->deviceService->listAll();
        return view('admin.devices.list')->with('user', session('user'))->with('devices', $device_list);
    }

    public function show($id)
    {
        $device = $this->deviceService->getById($id);
        // dd($device);
        if ($device == null) {
            return redirect()->route('devices')->with('error', 'Device not found');
        }
        $iotSubDevices = [];
        foreach ($device->iotSubDevices as $item) {
            array_push($iotSubDevices, $item->id);
        }
        $device_list = $this->deviceService->listAllComponents();
        $device_data = new stdClass();
        $device_data->types = $this->deviceService->getDeviceTypes();
        $device_data->config_types = $this->deviceService->getConfigTypes();
        $device_data->sensor_types = $this->deviceService->getSensorTypes();
        return view('admin.devices.single')
            ->with('user', session('user'))
            ->with('device', $device)
            ->with('device_data', $device_data)
            ->with('device_list', $device_list)
            ->with('iotSubDevices', $iotSubDevices);
    }

    public function relationship($id)
    {
        $device = $this->deviceService->getById($id);
        $deviceRelationships = $this->deviceService->getRelationships($id);
        // dd($deviceRelationships);

        if ($device == null) {
            return redirect()->route('devices')->with('error', 'Device not found');
        }
        return view('admin.devices.relationship')
            ->with('user', session('user'))
            ->with('device', $device)
            ->with('deviceRelationships', $deviceRelationships);
    }

    public function create()
    {
        $device_list = $this->deviceService->listAllComponents();
        $device_data = new stdClass();
        $device_data->types = $this->deviceService->getDeviceTypes();
        $device_data->config_types = $this->deviceService->getConfigTypes();
        $device_data->sensor_types = $this->deviceService->getSensorTypes();
        return view('admin.devices.create')
            ->with('user', session('user'))
            ->with('device_data', $device_data)
            ->with('device_list', $device_list)
            ->with('token_data', session('token_data'));
    }

    public function update(Request $request, $id)
    {
        $subDevices = $request->iotSubDevices;
        $subDeviceArray = [];
        if ($subDevices != null) {
            foreach ($subDevices as $value) {
                $subDevice = (object)[
                    'iotDeviceId' => $value,
                ];
                array_push($subDeviceArray, $subDevice);
            }
        }

        $request['iotSubDevices'] = $subDeviceArray;
        $result = $this->deviceService->update($id, $request);
        if ($result != null) {
            return redirect()->route('devices.show', ['id' => $id])->with('message', 'Device updated successfully');
        }
        return redirect('devices.show',  ['id' => $id])->with('error', 'Unable to Update');
    }

    public function store(Request $request)
    {
        $subDevices = $request->iotSubDevices;
        $subDeviceArray = [];
        if ($subDevices != null) {
            foreach ($subDevices as $value) {
                $subDevice = (object)[
                    'iotDeviceId' => $value,
                ];
                array_push($subDeviceArray, $subDevice);
            }
        }

        $request['iotSubDevices'] = $subDeviceArray;
        $result = $this->deviceService->create($request);
        if ($result != null) {
            $token_data = $this->deviceService->generateToken($result->id);
            session(['token_data', $token_data]);
            return redirect()->route('devices.create')->with('message', 'Device Created successfully');
        }
        return redirect()->route('devices.create')->with('message', 'Device Created successfully');
    }

    public function telemetryLogs($id)
    {
        $device = $this->deviceService->getById($id);
        if ($device == null) {
            return redirect()->route('devices')->with('error', 'Device not found');
        }

        return view('admin.telemetry.logs')
            ->with('user', session('user'))
            ->with('device', $device);
    }

    public function analysis($id)
    {
        $device = $this->deviceService->getById($id);
        if ($device == null) {
            return redirect()->route('devices')->with('error', 'Device not found');
        }

        return view('admin.digitaltwin.analysis')
            ->with('user', session('user'))
            ->with('device', $device);
    }
}
