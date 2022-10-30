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
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">{{ __('app.Courses') }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ __('app.main') }}</a></li>
                        <li class="breadcrumb-item"><a href="/edu">{{ __('app.Courses') }}</a></li>
                        <li class="breadcrumb-item active">{{ $course->title }}</li>
                    </ol>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 p-20">
                    <h3 class="card-title">{{ $course->title }}</h3>
                    <ul class="list-unstyled">
                        <li class="media">
                            <img class="d-flex mr-3" src="/{{ $course->preview }}" width="350" alt="Generic placeholder image">
                            <div class="media-body">
                                <h4 class="mt-0 mb-1">{{ __('app.Description') }}:</h4> {!!$course->desc  !!}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 p-20">
                    <h4 class="card-title">{{ __('app.Next lessons') }}</h4>
                    <ul class="list-unstyled">
                        @foreach($lessons as $item)
                            <li class="media">
                                <img class="d-flex mr-3" src="/{{ $item->preview }}" width="250" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1"><a href="/edu/lesson/{{ $item->id }}">{{ $item->title }}</a></h5>
                                    {!! Illuminate\Support\Str::limit(strip_tags($item->desc), 500); !!}
                                    <br>
                                    <a href="/edu/lesson/{{ $item->id }}" class="btn btn-success m-t-15">{{ __('app.More details') }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        @include('layouts.footer')
    </div>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection


