@extends('layouts.admin_app')
@section('title')
    Digital Twin Analysis
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
                                {{ $device->name }} Analysis
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <form id="query_form">
                            <div class="row nav-wrapper position-relative end-0">
                                <input type="hidden" name="" value="{{ $device->id }}" id="deviceId">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="dateFrom" class="form-control-label">Date From</label>
                                        <input type="datetime-local" step="1" value="" required name="dateFrom"
                                            class="form-control" id="dateFrom">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="dateTo" class="form-control-label">Date To</label>
                                        <input type="datetime-local" step="1" value="" required name="dateTo"
                                            class="form-control" id="dateTo">
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary link-loader">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Analyze Twin</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="table_main" class="table align-items-center mb-0"
                                    style="max-height: 1500px; overflow-y: auto">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Timestamp</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Performance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom-script')
    <script>
        let telemetryData = null;
        const date = new Date();
        $('#query_form').submit(function(e) {
            document.getElementById('loader').style.display = 'block';
            e.preventDefault();
            let dateFrom = $('#dateFrom').val();
            let dateTo = $('#dateTo').val();
            let deviceId = $('#deviceId').val();
            $.ajax({
                url: `{{ env('API_URL') }}DigitalTwins/evaluate?iOTDeviceId=${deviceId}&startDate=${dateFrom}&endDate=${dateTo}`,
                type: 'GET',
                data: null,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer {{ session('token') }}`
                },
                success: function(response) {
                    document.getElementById('loader').style.display = 'none';
                    telemetryData = response.data;
                    fillTable();
                },
                error: function(xhr, status, error) {
                    document.getElementById('loader').style.display = 'none';
                    var _error = JSON.parse(xhr.responseText).errors
                    _error.map(e => {
                        toastr.error(e.errorMessages.toString());
                    })
                }
            });
        });

        let fillDeviceInfo = null;

        function resolveDeviceStatus(deviceStatus) {
            if (deviceStatus != null) {
                let status =
                    `Operational Status : ${deviceStatus.operationalStatus} <br>
                Power Status : ${deviceStatus.powerStatus} <br>
                Maintennce Status : ${deviceStatus.maintenanceStatus} <br>
                Performance Status : ${deviceStatus.performanceStatus} <br>
                Health Status : ${deviceStatus.healthStatus} <br>
                Configuration Status : ${deviceStatus.configurationStatus} <br>`;
                return status;
            }

            return 'None';
        }

        function resolveReactions(deviceReactions) {
            if (deviceReactions != null && deviceReactions.length > 0) {
                let reaction = '';
                deviceReactions.forEach(e => {
                    reaction += `Device Name: ${e.deviceName} <br>
                                 Working Properly: ${e.workingProperly} <br>
                                 Errors: ${e.errors.toString()} <br>`;
                });
                return reaction;
            }

            return 'None';
        }

        function fillTable() {
            var tableData = '';
            var videoSensor = '';
            telemetryData.forEach(e => {
                let content = '';
                let tableRowBegin = '<tr><td class="align-middle text-center text-sm"><h6 class="mb-0 text-sm">' + e
                    .timestamp + '</h6></td>';

                if (e.dhT11SensorData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e.dhT11SensorData
                        .deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.dhT11SensorData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.dhT11SensorData.reactions) + ' </h6> </td>';
                }
                if (e.ultrasonicSensorData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .ultrasonicSensorData.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.ultrasonicSensorData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.ultrasonicSensorData.reactions) + ' </h6> </td>';
                }
                if (e.ledSensorData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .ledSensorData.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.ledSensorData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.ledSensorData.reactions) + ' </h6> </td>';
                }
                if (e.lightSensorData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .lightSensorData.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.lightSensorData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.lightSensorData.reactions) + ' </h6> </td>';
                }
                if (e.motionSensorData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .motionSensorData.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.motionSensorData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.motionSensorData.reactions) + ' </h6> </td>';
                }
                if (e.gpsData != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .gpsData.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.gpsData.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.gpsData.reactions) + ' </h6> </td>';
                }
                if (e.cameraSensor != null) {
                    content += '<td class="align-middle  text-sm"><h6 class="mb-0 text-sm"> ' + e
                        .cameraSensor.deviceName +
                        ' <br/>Device Status ' + resolveDeviceStatus(e.cameraSensor.deviceStatus) +
                        ' <br/>Reactions ' + resolveReactions(e.cameraSensor.reactions) + ' </h6> </td>';
                }
                let tableEnd = '</td > </tr>';

                tableData += tableRowBegin + content + tableEnd;
            });
            $('#table_body').html(tableData);
        };
    </script>
@endsection
