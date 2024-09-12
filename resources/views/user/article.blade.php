@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" onclick="history.back()">戻る</button>
    <dl>
        @foreach($articles as $article)
        <form>
            <label for="posted_date">
                <div class="form-group">{{ $article->posted_date }}</div>
            </label><br>
            <label for="title">
                <div class="form-group">{{ $article->title }}</div>
            </label><br>
            <label for="article_contents">
                <div class="form-group">{{ $article->article_contents }}</div>
            </label><br>
        </form>
        @endforeach
    </dl>
</div>
@endsection
