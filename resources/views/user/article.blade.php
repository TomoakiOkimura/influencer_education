@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class ="button">
        <button type="button" class="btn btn-secondary btn-sm " onclick="history.back()">戻る</button>
    </div>
    <dl>
        @foreach($articles as $article)
        <form>
            <label for="posted_date">
                <div class="form-group">{{ $article->posted_date }}</div>
            </label><br>
            <label for="title">
                <h1 class="form-group">{{ $article->title }}</h1>
            </label><br>
            <label for="article_contents">
                <div class="article_contents">{{ $article->article_contents }}</div>
            </label><br>
        </form>
        @endforeach
    </dl>
</div>
@endsection
