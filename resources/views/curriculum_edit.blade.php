@extends('layouts.app')

@section('content')
{{-- 授業更新登録ページ --}}
          
            <div class="container-cc1">
                <a href="{{route('admin.show.curriculum.list')}}" class="back-link">← 戻る</a>
                <h1>授業設定</h1>
                
                <form action=" {{route('admin.curriculum.edit',['id' => $curriculum->id])}}" method="POST" enctype='multipart/form-data'>
                   {{-- フォームの中身 {{route('curriculum.create')}} --}}
                    @csrf
                    <div class="thumbnail-upload">
                        {{-- サムネイルの表示 --}}
                        {{-- 画像のインプットタグ --}}
                        @if($curriculum->thumbnail)
                        <img src="{{ asset($curriculum->thumbnail) }}" class="img-register">
                        @endif
                        <div>
                        <input type="file" name="image">
                        </div>
                        </div>
                        <table>
                        <tr><td>学年</td>
                            <td>
                                <select name="grade_id">

                                    <option value="{{$curriculum->grade_id}}">{{$curriculum->name}}</option>
                                    @foreach($grades as $grade)
                                    <option value="{{$grade -> id}}">{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </td></tr>
                        <tr><td>授業名</td><td><input type="text" name="title" value="{{$curriculum -> title}}"></td><tr>
                        <tr><td>動画URL</td><td><input type="text" name="video_url" value="{{$curriculum -> video_url }}"></td><tr>
                        <tr><td>授業概要</td><td><textarea name="description" value="{{$curriculum -> description}}"></textarea></td><tr>
                        
                    </table>
                    <label>
                    {{-- 
                    ここの常時公開チェックボックスにフラグが１のときにチェックが入った状態を保持 チェックない登録だったらDBに０を登録 --}}
                    <input type="hidden" name=" alway_delivery_flg" value='0'>
                    @if($flg = 1)
                    <input type="checkbox" name="alway_delivery_flg" value="{{$curriculum -> alway_delivery_flg	}}" checked="checked">常時公開</label>
                    @else
                    <input type="checkbox" name="alway_delivery_flg" value="{{$curriculum -> alway_delivery_flg	}}" >常時公開</label>
                    @endif
                        <button type="submit" class="btn btn-primary">登録</button>
                </form>
            </div> 
            </div>
    </body>
</html>
@endsection