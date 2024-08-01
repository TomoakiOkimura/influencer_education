@extends('layouts.app')

@section('content')
<script src="{{ asset('js/delivery.js') }}"></script>
<div class="container-d">
    <a href="{{ route('admin.show.curriculum.list') }}" class="back">←戻る</a>
    <h1>配信日時設定</h1>

    <div class="container-d1">
        <h4>授業タイトルが入る</h4>

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
                    @for($i = 0; $i < 3; $i++)
                        <tr>
                            <td>
                                <input type="text" name="delivery_from_date[]"
                                    value="{{ old('delivery_from_date.' . $i, isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_from)->format('Ymd') : '') }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="text" name="delivery_from_time[]"
                                    value="{{ old('delivery_from_time.' . $i, isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_from)->format('Hi') : '') }}"
                                    placeholder="時分">
                            </td>
                            <td><h3>～</h3></td>
                            <td>
                                <input type="text" name="delivery_to_date[]"
                                    value="{{ old('delivery_to_date.' . $i, isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_to)->format('Ymd') : '') }}"
                                    placeholder="年月日">
                            </td>
                            <td>
                                <input type="text" name="delivery_to_time[]"
                                    value="{{ old('delivery_to_time.' . $i, isset($delivery_times[$i]) ? \Carbon\Carbon::parse($delivery_times[$i]->delivery_to)->format('Hi') : '') }}"
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