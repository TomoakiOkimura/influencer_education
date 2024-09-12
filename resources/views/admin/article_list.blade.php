@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" onclick="history.back()">戻る</button>
    <div>お知らせ一覧</div>
    <th><a href="{{ route('admin.article_create') }}" class="btn btn-warning btn-sm mx-1">新規登録</a></th>
    <table id="fav-table" class= "table table-striped" border="2">
        <thead>
            <tr>
                <th>投稿日時</th>
                <th>タイトル</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($articles as $article)
            <tr>
                <th scope="row">{{ $article->posted_date }}</th>
                <td>{{ $article->title }}</td>
                <td><a href="{{ route('admin.article_edit', ['article' => $article] ) }}" class="btn btn-info btn-sm mx-1">変更する</a></td>
                <td>
                    <form method="POST" action="{{ route('admin.article_destroy', $article) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
