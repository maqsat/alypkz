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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('app.main') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('app.Courses') }}</li>
                    </ol>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Row -->
                    <div class="row">
                    @foreach($course as $item)
                        <!-- column -->
                        <div class="col-lg-4 col-md-4 img-responsive">
                            <!-- Card -->
                            <div class="card">
                                <img class="card-img-top img-responsive img-responsive-course" src="{{ $item->preview }}" alt="Card image cap">
                                <div class="card-block">
                                    <h4 class="card-title">{{ $item->title }}</h4>
                                    <p class="card-text">{!! Illuminate\Support\Str::limit(strip_tags($item->desc), 200); !!}</p>
                                    <a href="/edu/{{$item->id}}" class="btn btn-success m-t-15">{{ __('app.More details') }}</a>
                                </div>
                            </div>
                            <!-- Card -->
                        </div>
                        <!-- column -->
                        @endforeach
                    </div>
                    <!-- Row -->
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


