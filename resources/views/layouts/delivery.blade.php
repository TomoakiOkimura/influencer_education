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

    <!-- 動画 -->
    <div class="video">
        @if($curriculum->always_public || ($curriculum->start_date <= now() && $curriculum->end_date >= now()))
            <video src="{{ $curriculum->video_url }}" controls></video>
        @else
            <img src="{{ asset('images/placeholder.png') }}" alt="代替画像">
        @endif
    </div>

    <!-- 学年 -->
    <div class="grade">
        <h2>学年: {{ $curriculum->grade->name }}</h2>
    </div>

    <!-- 授業タイトル -->
    <div class="title">
        <h1>{{ $curriculum->title }}</h1>
    </div>

    <!-- 講座内容 -->
    <div class="description">
        <p>{{ $curriculum->description }}</p>
    </div>

    <!-- 受講しましたボタン -->
    <div class="complete-button">
        @if($curriculum->always_public || ($curriculum->start_date <= now() && $curriculum->end_date >= now()))
            <button id="complete-btn" @if($progress && $progress->clear_flag) disabled @endif>
                @if($progress && $progress->clear_flag)
                    受講済
                @else
                    受講しました
                @endif
            </button>
        @endif
    </div>
</div>

<script>
    document.getElementById('complete-btn').addEventListener('click', function() {
        const curriculumId = '{{ $curriculum->id }}';
        fetch(`/delivery/${curriculumId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            this.textContent = '受講済';
            this.disabled = true;
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
