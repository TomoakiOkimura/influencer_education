@extends('layouts.app')

@section('content')
<div class="container-cc1">
    <a href="{{ route('admin.search.curriculum.list', $curriculum->grade_id) }}" class="back-link">← 戻る</a>
    <h1>授業設定</h1>
    <form action="{{ route('admin.curriculum.edit', ['id' => $curriculum->id]) }}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div class="thumbnail-upload">
            @if($curriculum->thumbnail)
                <img src="{{ asset($curriculum->thumbnail) }}" class="img-register">
            @else
                <img src="{{ asset('/storage/images/NoImage.jpg') }}" class="img">
            @endif
            <div>
                <input type="file" name="image">
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <table>
            <tr>
                <td>学年</td>
                <td>
                    <select name="grade_id">
                        <option value="{{ $curriculum->grade_id }}">{{ $curriculum->name }}</option>
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
                    <input type="text" name="title" value="{{ old('title', $curriculum->title) }}">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>動画URL</td>
                <td>
                    <input type="text" name="video_url" value="{{ old('video_url', $curriculum->video_url) }}">
                    @error('video_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>授業概要</td>
                <td>
                    <textarea name="description">{{ old('description', $curriculum->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        </table>
        <label>
            <input type="hidden" name="alway_delivery_flg" value="0">
            <input type="checkbox" name="alway_delivery_flg" value="1" 
                @if(old('alway_delivery_flg', $curriculum->alway_delivery_flg) == 1) checked @endif>
            常時公開
        </label>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>
@endsection