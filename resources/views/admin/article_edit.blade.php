@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" class="btn btn-secondary btn-sm " onclick="history.back()">戻る</button>
    <h2>お知らせ変更</h2>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.article_update', $article) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="posted_date" class="form-label">投稿日時</label>
                <input type="text" class="form-control" id="posted_date" name="posted_date" value="{{ $article->posted_date }}" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
            </div>

            <div class="mb-3">
                <label for="article_contents" class="form-label">コメント</label>
                <textarea id="article_contents" name="article_contents" class="form-control" rows="3">{{ $article->article_contents }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">変更</button>
        </form>
    </div>
</div>

@endsection
