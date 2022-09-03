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
                    <h3 class="text-themecolor m-b-0 m-t-0">Новости</h3>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="row">
                <div class="col-12">

                    @foreach($news as $item)
                    <div class="card">
                        <div class="card-block">
                            <h2>
                                <img class="ipull-left m-r-20 m-b-10" width="150" alt="user" src="{{ $item->news_image }}" alt="user">
                                {{ $item->news_name }}
                            </h2>
                            <hr class="m-t-10">
                            <p class="m-t-10">
                                {!! $item->news_desc  !!}
                            </p>
                            <a href="/profile-news/{{ $item->id }}" class="btn btn-info btn-rounded btn-outline m-t-20">Читать далее</a>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    @include('layouts.footer')
    <!-- ============================================================== -->
    </div>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection
