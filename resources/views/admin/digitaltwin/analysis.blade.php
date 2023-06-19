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
                            <h6>Telemetry Log</h6>
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
                url: `{{ env('API_URL') }}DigitalTwins/get-all?iOTDeviceId=${deviceId}&startDate=${dateFrom}&endDate=${dateTo}`,
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

        function fillTable() {
            var tableData = '';
            var videoSensor = '';
            telemetryData.forEach(e => {
                let content = '';
                let tableRowBegin = '<tr><td class="align-middle text-center text-sm"><h6 class="mb-0 text-sm">' + e
                    .timeStamp + '</h6></td><td class="align-middle  text-sm">';

                if (e.dhT11SensorData != null) {
                    content += '<h6 class="mb-0 text-sm"> DHT11 Sensor: Temp => ' + e.dhT11SensorData.temperature +
                        ', Humidity => ' + e.dhT11SensorData.humidity + '%</h6> ';
                }
                if (e.ultrasonicSensorData != null) {
                    content += '<h6 class="mb-0 text-sm"> Ultrasonic Sensor: Distance => ' + e.ultrasonicSensorData
                        .distance +
                        ', Duration => ' + e.ultrasonicSensorData.duration + '</h6> ';
                }
                if (e.ledSensorData != null) {
                    content += '<h6 class="mb-0 text-sm"> Led Sensor: Is On => ' + e.ledSensorData
                        .isOn + '</h6> ';
                }
                if (e.lightSensorData != null) {
                    content += '<h6 class="mb-0 text-sm"> Light Sensor: Value => ' + e.lightSensorData
                        .value + '</h6> ';
                }
                if (e.motionSensorData != null) {
                    content += '<h6 class="mb-0 text-sm"> Motion Sensor: Motion Detected => ' + e.motionSensorData
                        .motionDetected + '</h6> ';
                }
                if (e.gpsData != null) {
                    content += '<h6 class="mb-0 text-sm"> GPS Sensor: Longitude => ' + e.gpsData
                        .longitude +
                        ', Latitude => ' + e.gpsData.latitude + '</h6> ';
                }
                if (e.cameraSensor != null) {
                    videoSensor +=
                        `<div class="col"><img style="width:240px; height:180px" class="img-cap" src="data:image/png;base64,${e.cameraSensor.data}" alt="Base64 Image"></div>`
                }
                let tableEnd = '</td > </tr>';

                tableData += tableRowBegin + content + tableEnd;
            });
            $('#table_body').html(tableData);
            if (videoSensor) {
                $('#img-holder').html(videoSensor);
            }
        };

        function loadVideo() {
            var base64Video = "";
        }
    </script>
@endsection
