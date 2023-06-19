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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="">
                                <h3>Device Relationships</h3>
                                <p>This relationships and/or rules, are used to predetermine how the digital twin
                                    should function, giving you free will to build your twin</p>
                            </div>
                            <button type="button" class="btn btn-success addButton">Add</button>
                        </div>
                        <div id="baseMain">
                            <div id="template" class="card-body box d-none shadow iotMainRel">
                                <form action="">
                                    <div id="sub_devices" class="row">
                                        <input type="hidden" name="" value="" class="deviceRelationshipId">
                                        <input type="hidden" name="" class="mainIotDeviceId">
                                        {{-- Condition Block --}}
                                        <div class="col-md-4 iotRelCon">
                                            <h4>Condition Device</h4>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Device</label>
                                                <select name="iotDevice" class="form-control iotRelSelectConDevice"
                                                    id="">
                                                    <option selected disabled value="">None</option>
                                                    @if (count($device->iotSubDevices) > 0)
                                                        @foreach ($device->iotSubDevices as $item)
                                                            <option i={{ $item->iotSensorType }} j={{ $item->name }}
                                                                value="{{ $item->id }}">
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Parameter</label>
                                                <select required name="" class="form-control iotRelSelectConParam"
                                                    id="">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Condition</label>
                                                <select required name="" class="form-control iotRelSelectConCond"
                                                    id="">
                                                    <option value="0">Less Than (<) </option>
                                                    <option value="1">Greater Than (>)</option>
                                                    <option value="2">Less Than Equal To (<=) </option>
                                                    <option value="3">Greater Than Equal To (<=) </option>
                                                    <option value="4">Equal To (==)</option>
                                                    <option value="5">Not Equal To (!=)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Value</label>
                                                <input name="" class="form-control iotRelValueCon" id="">
                                            </div>
                                        </div>
                                        {{-- Reaction Block --}}
                                        <div class="col-md-4 iotRelRea">
                                            <h4>Reaction Device</h4>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Device</label>
                                                <select name="iotDevice" class="form-control iotRelSelectReaDevice"
                                                    id="">
                                                    <option selected disabled value="">None</option>
                                                    @if (count($device->iotSubDevices) > 0)
                                                        @foreach ($device->iotSubDevices as $item)
                                                            <option i={{ $item->iotSensorType }} j={{ $item->name }}
                                                                value="{{ $item->id }}">
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Parameter</label>
                                                <select required name="" class="form-control iotRelSelectReaParam"
                                                    id="">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Select
                                                    Condition</label>
                                                <select required name="" class="form-control iotRelSelectReaCond"
                                                    id="">
                                                    <option value="0">Less Than (<) </option>
                                                    <option value="1">Greater Than (>)</option>
                                                    <option value="2">Less Than Equal To (<=) </option>
                                                    <option value="3">Greater Than Equal To (<=) </option>
                                                    <option value="4">Equal To (==)</option>
                                                    <option value="5">Not Equal To (!=)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Value</label>
                                                <input name="" class="form-control iotRelValueRea" id="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit"
                                                class="btn btn-primary loader-link submitButton">Save</button>
                                            <button type="button"
                                                class="btn btn-danger loader-link deleteButton">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if (count($deviceRelationships) > 0)
                                @foreach ($deviceRelationships as $item)
                                    <div class="card-body box shadow iotMainRel">
                                        <form action="">
                                            <div id="sub_devices" class="row">
                                                <input type="hidden" name="" value="{{ $item->id }}"
                                                    class="deviceRelationshipId">
                                                {{-- Condition Block --}}
                                                <div class="col-md-4 iotRelCon">
                                                    <h4>Condition Device</h4>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Device</label>
                                                        <select name="iotDevice"
                                                            class="form-control iotRelSelectConDevice" id="">
                                                            <option disabled value="">None</option>
                                                            @if (count($device->iotSubDevices) > 0)
                                                                @foreach ($device->iotSubDevices as $_item)
                                                                    <option
                                                                        {{ $item->deviceOneId == $_item->id ? 'selected' : '' }}
                                                                        i={{ $_item->iotSensorType }}
                                                                        j={{ $_item->name }}
                                                                        value="{{ $_item->id }}">
                                                                        {{ $_item->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Parameter</label>
                                                        <select required name=""
                                                            class="form-control iotRelSelectConParam" id="">
                                                            <option selected>
                                                                {{ $item->deviceOneCondition->key }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Condition</label>
                                                        <select required name=""
                                                            class="form-control iotRelSelectConCond" id="">
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 0 ? 'selected' : '' }}
                                                                value="0">Less Than (<) </option>
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 1 ? 'selected' : '' }}
                                                                value="1">Greater Than (>)</option>
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 2 ? 'selected' : '' }}
                                                                value="2">Less Than Equal To (<=) </option>
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 3 ? 'selected' : '' }}
                                                                value="3">Greater Than Equal To (<=) </option>
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 4 ? 'selected' : '' }}
                                                                value="4">Equal To (==)</option>
                                                            <option
                                                                {{ $item->deviceOneCondition->condition == 5 ? 'selected' : '' }}
                                                                value="5">Not Equal To (!=)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input"
                                                            class="form-control-label">Value</label>
                                                        <input name=""
                                                            value="{{ $item->deviceOneCondition->value }}"
                                                            class="form-control iotRelValueCon" id="">
                                                    </div>
                                                </div>
                                                {{-- Reaction Block --}}
                                                <div class="col-md-4 iotRelRea">
                                                    <h4>Reaction Device</h4>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Device</label>
                                                        <select name="iotDevice"
                                                            class="form-control iotRelSelectReaDevice" id="">
                                                            <option selected disabled value="">None</option>
                                                            @if (count($device->iotSubDevices) > 0)
                                                                @foreach ($device->iotSubDevices as $_item)
                                                                    <option
                                                                        {{ $item->deviceTwoId == $_item->id ? 'selected' : '' }}
                                                                        i={{ $_item->iotSensorType }}
                                                                        j={{ $_item->name }}
                                                                        value="{{ $_item->id }}">
                                                                        {{ $_item->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Parameter</label>
                                                        <select required name=""
                                                            class="form-control iotRelSelectReaParam" id="">
                                                            <option selected>
                                                                {{ $item->deviceTwoReaction->key }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="form-control-label">Select
                                                            Condition</label>
                                                        <select required name=""
                                                            class="form-control iotRelSelectReaCond" id="">
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 0 ? 'selected' : '' }}
                                                                value="0">Less Than (<) </option>
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 1 ? 'selected' : '' }}
                                                                value="1">Greater Than (>)</option>
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 2 ? 'selected' : '' }}
                                                                value="2">Less Than Equal To (<=) </option>
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 3 ? 'selected' : '' }}
                                                                value="3">Greater Than Equal To (<=) </option>
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 4 ? 'selected' : '' }}
                                                                value="4">Equal To (==)</option>
                                                            <option
                                                                {{ $item->deviceTwoReaction->condition == 5 ? 'selected' : '' }}
                                                                value="5">Not Equal To (!=)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-text-input"
                                                            class="form-control-label">Value</label>
                                                        <input name="" class="form-control iotRelValueRea"
                                                            value="{{ $item->deviceTwoReaction->value }}" id="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit"
                                                        class="btn btn-primary loader-link submitButton">Save</button>
                                                    <button type="button"
                                                        class="btn btn-danger loader-link deleteButton">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <form action="{{ route('devices.update', $device->id) }}" method="post">
                            @csrf @method('POST')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom-script')
    <script>
        let objectParams = {
            MotionSensors: ["MotionDetected"],
            TemperatureSensors: ["Temperature", "Humidity"],
            HumiditySensors: ["Temperature", "Humidity"],
            GPSSensors: ["Longitude", "Latitude"],
            LightSensors: ["Value"],
            ProximitySensors: ["Distance"],
            LedSensor: ["IsOn"]
        };

        $(document).on('click', '.deleteButton', function() {
            var parentDiv = $(this).closest('.iotMainRel');
            parentDiv.remove();
            //implement delete from api
            var parentDiv = $(this).closest('.iotMainRel');
            var url = `{{ env('API_URL') }}`;
            var type = '';
            var deviceRelationship = parentDiv.find('.deviceRelationshipId');
            var deviceRelationshipId = deviceRelationship.val();

            if (deviceRelationshipId) {
                document.getElementById('loader').style.display = 'block';
                type = 'DELETE';
                url += `DeviceRelationships/${deviceRelationshipId}`;

                $.ajax({
                    url: url,
                    type: type,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer {{ session('token') }}`
                    },
                    success: function(response) {
                        toastr.success('Device Relationship Deleted Successfully');
                        document.getElementById('loader').style.display = 'none';
                        // var _userResponse = JSON.parse(response.responseText)
                        // console.log(_userResponse);
                    },
                    error: function(xhr, status, error) {
                        var _error = JSON.parse(xhr.responseText).errors;
                        _error.map(e => {
                            toastr.error(e.errorMessages.toString());
                        });
                        document.getElementById('loader').style.display = 'none';
                    }
                });
            }
        });

        $(document).on('change', '.iotRelSelectConDevice', function() {
            var iotSensorType = $(this).find(":selected").attr('i');
            var params = objectParams[iotSensorType];
            var parentDiv = $(this).closest('.iotRelCon');
            var paramSelect = parentDiv.find('.iotRelSelectConParam');
            paramSelect.empty();
            if (params) {
                for (var index = 0; index < params.length; index++) {
                    paramSelect.append('<option value="' + params[index] + '">' + params[index] +
                        '</option>');
                }
            }
        });

        $(document).on('change', '.iotRelSelectReaDevice', function() {
            var iotSensorType = $(this).find(":selected").attr('i');
            var params = objectParams[iotSensorType];
            var parentDiv = $(this).closest('.iotRelRea');
            var paramSelect = parentDiv.find('.iotRelSelectReaParam');
            paramSelect.empty();
            if (params) {
                for (var index = 0; index < params.length; index++) {
                    paramSelect.append('<option value="' + params[index] + '">' + params[index] +
                        '</option>');
                }
            }
        });

        $(document).on('click', '.submitButton', function(e) {
            document.getElementById('loader').style.display = 'block';
            e.preventDefault();

            var parentDiv = $(this).closest('.iotMainRel');
            var url = `{{ env('API_URL') }}`;
            var type = '';
            var mainIOTDeviceId = "{{ $device->id }}";
            var deviceRelationship = parentDiv.find('.deviceRelationshipId');
            var deviceRelationshipId = deviceRelationship.val();
            if (deviceRelationshipId) {
                type = 'PATCH';
                url += `DeviceRelationships/${deviceRelationshipId}`;
            } else {
                type = "POST";
                url += 'DeviceRelationships/create';

            }
            // Condition
            var condDeviceId = parentDiv.find('.iotRelSelectConDevice');
            var condRelParam = parentDiv.find('.iotRelSelectConParam');
            var condRelCondition = parentDiv.find('.iotRelSelectConCond');
            var condRelValue = parentDiv.find('.iotRelValueCon');

            //Reaction
            var reaDeviceId = parentDiv.find('.iotRelSelectReaDevice');
            var reaRelParam = parentDiv.find('.iotRelSelectReaParam');
            var reaRelCondition = parentDiv.find('.iotRelSelectReaCond');
            var reaRelValue = parentDiv.find('.iotRelValueRea');

            if (condDeviceId.val() == reaDeviceId.val()) {
                toastr.error("Condition and Reaction device cant be the same");
            } else if (condDeviceId.val() == null) {
                toastr.error("Condition device is required");
            } else {

                let deviceOneConditionData = {
                    'key': condRelParam.val(),
                    'condition': parseInt(condRelCondition.val()),
                    'value': condRelValue.val()
                };

                let deviceTwoConditionData = {
                    'key': reaRelParam.val(),
                    'condition': parseInt(reaRelCondition.val()),
                    'value': reaRelValue.val()
                };

                let jsonData = {
                    'mainIOTDeviceId': mainIOTDeviceId,
                    'deviceOneId': condDeviceId.val(),
                    'deviceTwoId': reaDeviceId.val(),
                    'deviceOneCondition': deviceOneConditionData,
                    'deviceTwoReaction': deviceTwoConditionData
                };

                // console.log(jsonData);

                $.ajax({
                    url: url,
                    type: type,
                    data: JSON.stringify(jsonData),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer {{ session('token') }}`
                    },
                    success: function(response) {
                        document.getElementById('loader').style.display = 'none';
                        toastr.success('Device Relationship Saved');
                        // console.log(_userResponse);
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('loader').style.display = 'none';
                        var _error = JSON.parse(xhr.responseText).errors
                        _error.map(e => {
                            toastr.error(e.errorMessages.toString());
                        });
                    }
                });
            }
        });

        $('.addButton').click(function(e) {
            var newAppend = $('#template').clone();
            newAppend.attr('id', '');
            newAppend.removeClass('d-none');
            console.log(newAppend);
            $('#baseMain').append(newAppend);
        });
    </script>
@endsection
