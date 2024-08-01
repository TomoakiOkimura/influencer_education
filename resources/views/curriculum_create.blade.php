@extends('layouts.app')

@section('content')
<div class="container-cc1">
    <a href="{{ route('admin.show.curriculum.list') }}" class="back-link">← 戻る</a>
    <h1>授業設定</h1>
    <form action="{{ route('admin.curriculum.create') }}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div class="thumbnail-upload">
            <img src="{{ asset('/storage/images/NoImage.jpg') }}" class="img">
            <input type="file" name="image">
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <table>
            <tr>
                <td>学年</td>
                <td>
                    <select name="grade_id">
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                    @error('grade_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>授業名</td>
                <td>
                    <input type="text" name="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>動画URL</td>
                <td>
                    <input type="text" name="video_url" value="{{ old('video_url') }}">
                    @error('video_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>授業概要</td>
                <td>
                    <textarea name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        </table>
        <label>
            <input type="hidden" name="alway_delivery_flg" value='0'>
            <input type="checkbox" name="alway_delivery_flg" value="1">常時公開
        </label>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>
@endsection