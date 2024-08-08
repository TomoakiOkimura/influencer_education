@extends('layouts.app')

@section('content')
<script src="{{ asset('js/delivery.js') }}"></script>
<div class="container-d">
    <a href="{{ route('admin.show.curriculum.list') }}" class="back">←戻る</a>
    <h1>配信日時設定</h1>

    <div class="container-d1">
        <h4>{{ $curriculum->title }}</h4> <!-- 変更②: 授業タイトルを表示 -->

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.delivery.update', $curriculum->id) }}" method="POST">
            @csrf
            <table>
                <tbody id="delivery_times">
                    {{-- 変更③: DBに登録されている配信期間をすべて表示 --}}
                    @foreach($delivery_times as $index => $delivery_time)
                        <tr>
                            <td>
                                <input type="date" name="delivery_from_date[]"
                                    value="{{ old('delivery_from_date.' . $index, \Carbon\Carbon::parse($delivery_time->delivery_from)->format('Y-m-d')) }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_from_time[]"
                                    value="{{ old('delivery_from_time.' . $index, \Carbon\Carbon::parse($delivery_time->delivery_from)->format('H:i')) }}"
                                    placeholder="時分">
                            </td>
                            <td><h3>～</h3></td>
                            <td>
                                <input type="date" name="delivery_to_date[]"
                                    value="{{ old('delivery_to_date.' . $index, \Carbon\Carbon::parse($delivery_time->delivery_to)->format('Y-m-d')) }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_to_time[]"
                                    value="{{ old('delivery_to_time.' . $index, \Carbon\Carbon::parse($delivery_time->delivery_to)->format('H:i')) }}"
                                    placeholder="時分">
                            </td>
                            <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                    @endforeach
                    {{-- 変更④: 追加行を表示 --}}
                    @for($i = count($delivery_times); $i < count($delivery_times) + 1; $i++)
                        <tr>
                            <td>
                                <input type="date" name="delivery_from_date[]"
                                    value="{{ old('delivery_from_date.' . $i) }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_from_time[]"
                                    value="{{ old('delivery_from_time.' . $i) }}"
                                    placeholder="時分">
                            </td>
                            <td><h3>～</h3></td>
                            <td>
                                <input type="date" name="delivery_to_date[]"
                                    value="{{ old('delivery_to_date.' . $i) }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="time" name="delivery_to_time[]"
                                    value="{{ old('delivery_to_time.' . $i) }}"
                                    placeholder="時分">
                            </td>
                            <td><button type="button" class="delete-btn">×</button></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <button type="button" id="add-row">+</button>
            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
</div>
@endsection