@extends('user.layouts.app')

@section('content')
<div class="container">
    <button type="button" class="btn btn-secondary btn-sm " onclick="history.back()">戻る</button>
    <h1>プロフィール変更</h1>

    <dl>
        <form method="POST" action="{{ route('user.profile_update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="profile_image" class="form-label">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="商品画像" class="profile_image"><br>
                    プロフィール画像
                    <input id="profile_image" type="file" name="profile_image" class="form-control">
                    @if($errors->has('profile_image'))
                        <p style="color:#ff0000">{{ $errors->first('profile_image') }}</p>
                    @endif
                </label>
            </div><br>

            <div class="mb-3">
                <label for="name" class="form-label">ユーザーネーム</label>  
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                @if($errors->has('name'))
                    <p style="color:#ff0000">{{ $errors->first('name') }}</p>
                @endif
            </div><br>

            <div class="mb-3">
                <label for="name_kana" class="form-label">カナ</label>
                <input type="text" class="form-control" id="name_kana" name="name_kana" value="{{ $user->name_kana }}">
                @if($errors->has('name_kana'))
                    <p style="color:#ff0000">{{ $errors->first('name_kana') }}</p>
                @endif
            </div><br>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                @if($errors->has('email'))
                    <p style="color:#ff0000">{{ $errors->first('email') }}</p>
                @endif
            </div><br>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label><br>
                <a href="{{ route('user.password_edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm mx-1">パスワードを変更する</a>
            </div><br>

            <button type="submit" class="btn btn-success">変更</button>
        </form>
    </dl>
</div>
@endsection
