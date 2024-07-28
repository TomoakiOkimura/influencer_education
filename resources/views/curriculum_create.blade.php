@extends('layouts.app')

@section('content')
{{-- 授業新規登録ページ --}}
<div class="container-cc1">
    <a href="{{route('admin.show.curriculum.list')}}" class="back-link">← 戻る</a>
    <h1>授業設定</h1>
                <form action=" {{route('admin.curriculum.create')}}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    <div class="thumbnail-upload">
                        {{-- サムネイルの表示 --}}
                        {{-- 画像のインプットタグ --}}
                        <input type="file" name="image">
                    </div>
                    <table>
                        <tr><td>学年</td>
                            <td>
                                <select name="grade_id">
                                    @foreach($grades as $grade)
                                    <option value="{{$grade -> id}}">{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </td></tr>
                        <tr><td>授業名</td><td><input type="text" name="title"></td><tr>
                        <tr><td>動画URL</td><td><input type="text" name="video_url"></td><tr>
                        <tr><td>授業概要</td><td><textarea name="description"></textarea></td><tr>
                    </table>
                    {{-- 常時公開ボタン --}}
                    <label>
                    <input type="hidden" name=" alway_delivery_flg" value='0'>
                    <input type="checkbox" name="alway_delivery_flg" value="1">常時公開</label>
                    {{-- 登録ボタン --}}
                        <button type="submit" class="btn btn-primary">登録</button>
                </form>
            </div> 
            </div>
    </body>
</html>
@endsection
