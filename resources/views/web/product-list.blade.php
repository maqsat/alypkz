@extends('web.layout')

@section('content')
    <section class="page about" id="page-about">
        <div class="container">
            <div class="page-header">
                <ul class="page-path">
                    <li><a href="#" class="page-path-link">Главная</a></li>
                    <li><a href="#" class="page-path-link isActive">О продукте</a></li>
                </ul>
                <div class="page-title">
                    <h1>О продукте</h1>
                </div>
            </div>
            <div class="page-body">
                <div class="row">
                    @foreach($products as $item)
                    <div class="col-4" style="margin-bottom: 20px">
                        <div class="card-columns text">

                                <div class="card ribbon-wrapper">
                                    {{--<div class="ribbon ribbon-bookmark  ribbon-danger">+ {{ $item->cv }} cv</div>--}}
<!--                                    <div class="ribbon ribbon-bookmark  ribbon-info">+ {{ $item->pv }} pv</div>-->
                                    <img class="card-img-top img-fluid" src="{{ $item->image1 }}" alt="{{ $item->title }}">
                                    <div class="card-block">
                                        <h4 class="card-title">{{ $item->title }}</h4>
                                        <div class="card-text m-b-15">{!! str_limit(strip_tags($item->description), 200) !!}</div>
                                        <div class="button btn-success text-center">{{ $item->partner_cost }} $</div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
