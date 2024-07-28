@extends('layouts.app')

@section('content')
<script src="{{ asset('js/delivery.js') }}"></script>
 {{-- 配信期間更新登録 --}}
<div class="container-d">
    <a href="{{ route('admin.show.curriculum.list') }}" class="back">←戻る</a>
    <h1>配信日時設定</h1>

    <div class="container-d1">
        <h4>授業タイトルが入る</h4>
        
        <form action="{{ route('admin.delivery.update', $curriculum->id) }}" method="POST">
            @csrf
            <table>
              
                <tbody id="delivery_times">
                    @for($i = 0; $i < 3; $i++)
                        <tr>
                            <td>
                                <input type="date" name="delivery_from_date[]"
                                    value="{{ isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_from)->format('Y-m-d') : '' }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_from_time[]"
                                    value="{{ isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_from)->format('H:i') : '' }}"
                                    placeholder="時分">
                            </td>
                            <td><h3>～</h3></td>
                            <td>
                                <input type="date" name="delivery_to_date[]"
                                    value="{{ isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_to)->format('Y-m-d') : '' }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_to_time[]"
                                    value="{{ isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_to)->format('H:i') : '' }}"
                                    placeholder="時分">
                            </td>
                            {{-- 削除ボタン --}}
                            <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            {{-- 行追加ボタン --}}
            <button type="button" id="add-row" >+</button>
            {{-- 登録ボタン --}}
            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
</div>
@endsection