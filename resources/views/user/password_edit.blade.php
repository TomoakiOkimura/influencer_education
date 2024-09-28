@extends('layouts.app')

@section('content')
<div class="container">
    <button type="button" class="btn btn-secondary btn-sm " onclick="history.back()">戻る</button>
    <h2>パスワード変更</h2>
    
    <form method="POST" action="{{ route('user.password_update') }}">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="old_password" class="form-label">旧パスワード</label>
            <input type="password" class="form-control" id="old_password" name="old_password">
            @error('old_password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">新パスワード</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
            @error('new_password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">新パスワード確認</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
        </div>

        <button type="submit" class="btn btn-success">変更</button>
    </form>
</div>

@endsection
