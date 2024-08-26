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
                                {{ $device->name }} Stream
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <form id="query_form">
                            <div class="row nav-wrapper position-relative end-0">
                                <input type="hidden" name="" value="{{ $device->id }}" id="deviceId">
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
                            <h6>Stream Data</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <video id="my-video" class="video-js vjs-big-play-centered vjs-theme-sea" controls
                                preload="auto" fluid="true" poster="https://st.depositphotos.com/1005920/3441/i/450/depositphotos_34415065-stock-photo-live-stream-icon.jpg"
                                data-setup='{}'>
                                <source
                                    src="http://spytrans.eastus2.cloudapp.azure.com/hls/Video-20230627_120559-Meeting_Recording.m3u8"
                                    type="application/x-mpegURL">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom-script')
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://unpkg.com/videojs-contribhls/dist/videojs-contrib-hls.js"></script>

    <script>
        var player = videojs('my-video');
    </script>
@endsection
