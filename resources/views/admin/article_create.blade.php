@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" onclick="history.back()">戻る</button>
    <div>お知らせ変更</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.article_store')}}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="posted_date" class="form-label">投稿日時</label>
                <input type="date" class="form-control" id="posted_date" name="posted_date" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="article_contents" class="form-label">コメント</label>
                <textarea id="article_contents" name="article_contents" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">登録</button>
        </form>
    </div>
</div>

@endsection
