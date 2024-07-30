@extends('layouts.app')

@section('content')
<script src="{{ asset('js/delivery.js') }}"></script>

            {{-- 配信期間新規登録 --}}
            <a href="{{route('admin.show.curriculum.list')}}" class="back">←戻る</a>
            <div><h1>配信日時設定</h1></div>

            <div class="container-d1">
            <h4>授業タイトルが入る</h4>
     
                <form action="{{route('admin.delivery.new.create',$curriculum->id)}}" method="POST">
                     @csrf
                    <table>
                        <tbody id="delivery_times">
                        {{-- name属性の最後に[]を使用することでフォームで複数の値を送信する際に配列として同じ名前のデータをサーバーに送れる、
                        動的に増減するフォームフィールド（例配信期間を複数入力するフィールド）で使われる --}}
                        <tr><td><input type="text" name="delivery_from_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_from_time[]" placeholder="日時"></td>
                            <td><h3>～</h3></td>
                            <td><input type="text" name="delivery_to_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_to_time[]" placeholder="日時"></td>
                             {{-- 削除ボタン --}}
                             <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                        <tr><td><input type="text" name="delivery_from_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_from_time[]" placeholder="日時"></td>
                            <td><h3>～</h3></td>
                            <td><input type="text" name="delivery_to_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_to_time[]" placeholder="日時"></td>
                             {{-- 削除ボタン --}}
                             <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                        <tr><td><input type="text" name="delivery_from_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_from_time[]" placeholder="日時"></td>
                            <td><h3>～</h3></td>
                            <td><input type="text" name="delivery_to_date[]" placeholder="年月日"></td>
                            <td><input type="text" name="delivery_to_time[]" placeholder="日時"></td>
                             {{-- 削除ボタン --}}
                             <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                    </tbody>
                    </table>
                    {{-- 行追加ボタン --}}
            <button type="button" id="add-row">+</button>
                     {{-- フォーム送信登録ボタン    --}}
                    <button type="submit" class="btn btn-primary">登録</button>
                </form>
            </div>
        </div>
    </body>
</html>
@endsection