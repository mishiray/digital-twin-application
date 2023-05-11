@extends('layouts.admin_app')
@section('title')
    Device
@endsection
@section('content')
    <main class="main-content position-relative border-radius-lg ">
        <nav class="navbar mb-large navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
        </nav>
        <div class="card shadow-lg mx-4 card-profile-bottom">
            <div class="card-body p-3">
                <div class="row gx-4">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $device->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    Last HeartBeat: {{ $device->lastInitiatedConnection }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Device Info</p>
                            </div>
                        </div>
                        <form action="{{ route('devices.update', $device->id) }}" method="post">
                            @csrf @method('POST')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name</label>
                                            <input class="form-control" name="name" type="text"
                                                value="{{ $device->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Devuce Id</label>
                                            <input class="form-control" name="deviceId" type="text"
                                                value="{{ $device->deviceId }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Config Type</label>
                                            <select name="iotConfigType" required class="form-control" id="config_type">
                                                <option disabled value="">Choose Config</option>
                                                @if (count($device_data->config_types) > 0)
                                                    @foreach ($device_data->config_types as $item)
                                                        <option {{ $item == $device->iotConfigType ? 'selected' : '' }}
                                                            value="{{ $loop->index }}">{{ $item }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Device Type</label>
                                            <select name="iotDeviceType" class="form-control" id="type">
                                                <option disabled value="">Choose Type</option>
                                                <option>None</option>
                                                @if (count($device_data->types) > 0)
                                                    @foreach ($device_data->types as $item)
                                                        <option {{ $item == $device->iotDeviceType ? 'selected' : '' }}
                                                            value="{{ $loop->index }}">{{ $item }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Sensor Type</label>
                                            <select name="iotSensorType" class="form-control" id="sensor_type">
                                                <option disabled value="">Choose Type</option>
                                                <option>None</option>
                                                @if (count($device_data->sensor_types) > 0)
                                                    @foreach ($device_data->sensor_types as $item)
                                                        <option {{ $item == $device->iotSensorType ? 'selected' : '' }}
                                                            value="{{ $loop->index }}">{{ $item }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <div id="sub_devices" class="row">
                                    <div class="col-12">
                                        <p class="text-uppercase text-sm">Sub Devices</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Select Sub
                                                Devices</label>
                                            <select name="iotSubDevices[]" multiple class="form-control" id="iotSubDevices">
                                                <option disabled value="">Choose Devices</option>
                                                <option>None</option>
                                                @if (count($device_list) > 0)
                                                    @foreach ($device_list as $item)
                                                        <option {{ in_array($item->id, $iotSubDevices) ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit"
                                        class="btn btn-lg loader-link btn-primary btn-lg w-100 mt-4 mb-0">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom-script')
    <script>
        $(document).ready(function() {
            let deivce_config_type = `{{ $device->iotConfigType }}`
            if (deivce_config_type === "Component") {
                console.log(deivce_config_type);
                $('#sub_devices').addClass('d-none');
            } else {
                $('#sub_devices').removeClass('d-none');
            }
            $("#config_type").on("change", function() {
                if (this.value == 0) {
                    $('#sub_devices').removeClass('d-none');
                } else {
                    $('#sub_devices').addClass('d-none');
                }
            });
        });
    </script>
@endsection
