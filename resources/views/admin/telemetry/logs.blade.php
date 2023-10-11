@extends('layouts.admin_app')
@section('title')
    Telemetry
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
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">General Status</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold" id="iotDeviceSpan">4% more</span>
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="general-status" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid d-none py-4">
            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Camera Sensor</h6>
                        </div>
                        <div class="container" style="max-height: 1500px; overflow-y:auto">
                            <div id="img-holder" class="row">
                            </div>
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
                                                Log</th>
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
                url: `{{ env('API_URL') }}Telemetries/get-all?iOTDeviceId=${deviceId}&startDate=${dateFrom}&endDate=${dateTo}`,
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
                    loadUp();
                    fillTable();
                    if (telemetryData.cameraSensor !== null) {
                        loadVideo();
                    }
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

        function loadUp() {
            let chartStatus = Chart.getChart("general-status"); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }

            if (telemetryData != null) {
                fillDeviceInfo = telemetryData.map(e => ({
                    label: e.timeStamp,
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 2,
                    pointBackgroundColor: "#" + Math.floor(Math.random() * 16777215).toString(16),
                    borderColor: "#" + Math.floor(Math.random() * 16777215).toString(16),
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    data: [e.deviceStatus.operationalStatus, e.deviceStatus.powerStatus,
                        e.deviceStatus.maintenanceStatus, e.deviceStatus.performanceStatus,
                        e.deviceStatus.healthStatus, e.deviceStatus.configurationStatus
                    ],
                    maxBarThickness: 6
                }));
            }
            $('#iotDeviceSpan').html(`${telemetryData.length} records`);
            var fullDev = document.getElementById("general-status").getContext("2d");
            var gradientStroke1 = fullDev.createLinearGradient(0, 230, 0, 50);
            gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
            gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

            var gradientStroke2 = fullDev.createLinearGradient(0, 230, 0, 50);
            gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
            gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');
            var myChart = new Chart(fullDev, {
                type: "line",
                data: {
                    labels: ["Operational", "Power", "Maintenace", "Performance", "Health", "Configuraation"],
                    datasets: fillDeviceInfo,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#b2b9bf',
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: true,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#b2b9bf',
                                padding: 10,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        }

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

                    content +=
                        `</td>
                         <tdoh class="align-middle  text-sm>
                            <h6 class="mb-0 text-sm"><img style="width:240px; height:180px" class="img-cap" src="data:image/png;base64,${e.cameraSensor.data}" alt="Base64 Image"></h6>`
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
