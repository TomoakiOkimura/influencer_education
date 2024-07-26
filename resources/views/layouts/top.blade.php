@extends('layouts.app')

@section('content')
<div class="container">
    <!-- 共通ヘッダー -->
    <div class="header">
        <a href="{{ route('timetable') }}">時間割</a>
        <a href="{{ route('progress') }}">授業進捗</a>
        <a href="{{ route('profile') }}">プロフィール設定</a>
        @if(Auth::check())
            <a href="{{ route('logout') }}">ログアウト</a>
        @else
            <a href="{{ route('login') }}">ログイン</a>
        @endif
    </div>

    <!-- バナー画像 -->
    <div class="banner">
        @foreach($banners as $banner)
            <div class="banner-item">
                <img src="{{ asset('storage/' . $banner->image_path) }}" alt="バナー画像">
                <button onclick="showBanner('{{ $banner->id }}')">バナー画像を表示</button>
            </div>
        @endforeach
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
