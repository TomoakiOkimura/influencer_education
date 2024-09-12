@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" onclick="history.back()">戻る</button>
    <div>プロフィール変更</div>

    <dl>
        <form method="POST" action="{{ route('user.profile_update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="profile_image" class="form-label">プロフィール画像</label>
                <img alt="プロフィール画像" width="100">
                <input id="profile_image" type="file" name="profile_image" class="form-control" nullable>
            </div><br>

            <div class="mb-3">
                <label for="name" class="form-label">ユーザーネーム</label>  
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div><br>

            <div class="mb-3">
                <label for="name_kana" class="form-label">カナ</label>
                <input type="text" class="form-control" id="name_kana" name="name_kana" value="{{ $user->name_kana }}" required>
            </div><br>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div><br>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <div class="form-group">{{ $user->password }}</div>
                <a href="{{ route('user.password_edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm mx-1">パスワードを変更する</a>
            </div><br>

            <button type="submit" class="btn btn-success">変更</button>
        </form>
    </dl>
</div>
@endsection
