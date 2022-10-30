@extends('layouts.profile')

@section('in_content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-12 col-12 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">{{ __('app.Courses') }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ __('app.main') }}</a></li>
                        <li class="breadcrumb-item"><a href="/edu">{{ __('app.Courses') }}</a></li>
                        <li class="breadcrumb-item"><a href="/edu/{{ $course->id }}">{{ $course->title }}</a></li>
                        <li class="breadcrumb-item active">{{ $lesson->title }}</li>
                    </ol>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 p-20">
                    <h3 class="card-title">{{ $lesson->title }}</h3>
                    <ul class="list-unstyled">
                        <li class="video-media video-container">
                            {!! $lesson->video !!}
                        </li>
                    </ul>
                    <div class="media-body">
<!--                        <h4 class="mt-0 mb-1">{{ __('app.Description') }}:</h4> {!!$lesson->desc  !!}-->
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 p-20">
                    <h4 class="card-title">{{ __('app.Next lessons') }}</h4>
                    <div class="list-group">
                        @foreach($lessons as $item)
                        <a href="/edu/lesson/{{ $item->id }}" class="list-group-item list-group-item-action flex-column align-items-start @if($item->id == $lesson->id) active @endif">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 @if($item->id == $lesson->id) text-white @endif">{{ $item->title }}</h5>
                            </div>
                            <small>{{ __('app.Duration: 7 min') }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        @include('layouts.footer')
    </div>

    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection


