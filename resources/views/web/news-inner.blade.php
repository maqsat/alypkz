@extends('web.layout')

@section('content')
    <section class="page news-inner" id="page-news-inner">
        <div class="container">
            <div class="page-header">
                <ul class="page-path">
                    <li><a href="#" class="page-path-link">Главная</a></li>
                    <li><a href="#" class="page-path-link">Новости</a></li>
                    <li><a href="#" class="page-path-link isActive">{{ $news->news_name }}</a></li>
                </ul>
                <div class="page-title">
                    <h1>{{ $news->news_name }}</h1>
                </div>
            </div>
            <div class="page-body">
                <div class="news-inner-block">
                    {!! $news->news_text !!}
                </div>
            </div>
        </div>
    </section>
@endsection
