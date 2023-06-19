@extends('layouts.admin_app')
@section('title')
    IOT Devices
@endsection
@section('content')
    <main class="main-content position-relative border-radius-lg ">
        <nav class="navbar mb-large navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Devices table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                S/N</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Type</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                IsActive</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date Created</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($devices) > 0)
                                            @foreach ($devices as $item)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        <h6 class="mb-0 text-sm">{{ $loop->index + 1 }}</h6>
                                                    </td>
                                                    <td class="align-middle  text-sm">
                                                        <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <h6 class="mb-0 text-sm">{{ $item->iotConfigType }}</h6>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $item->isActive == 1 ? 'Active' : 'In Active' }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $item->timeStamp }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a class="btn loader-link btn-link text-dark px-3 mb-0"
                                                            href="{{ route('devices.show', $item->id) }}"><i
                                                                class="fas fa-pencil-alt text-dark me-2"
                                                                aria-hidden="true"></i>Edit</a>

                                                        <a class="btn loader-link btn-link text-dark px-3 mb-0"
                                                            href="{{ route('devices.relationship', $item->id) }}"><i
                                                                class="fas fa-pencil-alt text-dark me-2"
                                                                aria-hidden="true"></i>Relationship</a>

                                                        <a class="btn loader-link btn-link text-dark px-3 mb-0"
                                                            href="{{ route('devices.logs', $item->id) }}"><i
                                                                class="fas fa-chart-bar text-dark me-2"
                                                                aria-hidden="true"></i>Logs</a>

                                                        <a class="btn loader-link btn-link text-dark px-3 mb-0"
                                                            href="{{ route('devices.analysis', $item->id) }}"><i
                                                                class="fas fa-chart-pie text-dark me-2"
                                                                aria-hidden="true"></i>Analysis</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    No Devices found
                                                </td>
                                            </tr>
                                        @endif
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
@endsection
