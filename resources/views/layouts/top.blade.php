@extends('layouts.app')

@section('content')
<div class="container">

    <!-- バナー画像表示部分 -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($banners as $index => $banner)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ $banner->image_url }}" alt="Banner Image {{ $index + 1 }}">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- お知らせ -->
    <div class="articles">
        <h2>お知らせ</h2>
        @foreach($articles as $article)
            <div class="article">
                <h3><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h3>
                <p>{{ $article->summary }}</p>
            </div>
        @endforeach
    </div>
</div>

<script>
    function showBanner(bannerId) {
        alert('バナー画像ID: ' + bannerId + 'を表示します');
    }
</script>
@endsection
