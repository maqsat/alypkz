@extends('web.layout')

@section('content')
    <section class="page news" id="page-news">
        <div class="container">
            <div class="page-header">
                <ul class="page-path">
                    <li><a href="#" class="page-path-link">Главная</a></li>
                    <li><a href="#" class="page-path-link isActive">Новости</a></li>
                </ul>
                <div class="page-title">
                    <h1>Новости</h1>
                </div>
            </div>
            <div class="page-body">
                <div class="news-block">
                    <div class="news-grid">
                        @foreach($news as $item)
                            <a href="/web-news/{{$item->id}}" class="news-card">
                                <div class="news-card-img">
                                    <img src="{{ $item->news_image }}" alt="">
                                </div>
                                <div class="news-card-text">
                                    <h1>{{ $item->news_name }}</h1>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="news-pagination-block">
                        <div class="news-pagination page-pag">
<!--                            <a href="#" class="page-pag-left-btn">
                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 9L1 5L5 1" stroke="#9C9C9C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <div class="page-pag-body">
                                <a href="#" class="page-page-number">1</a>
                                <a href="#" class="page-page-number isActive">2</a>
                                <a href="#" class="page-page-number">3</a>
                                <a href="#" class="page-page-number">...</a>
                                <a href="#" class="page-page-number">20</a>
                            </div>
                            <a href="#" class="page-pag-right-btn">
                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 9L5 5L1 1" stroke="#9C9C9C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
