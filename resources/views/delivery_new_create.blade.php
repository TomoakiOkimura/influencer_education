@extends('layouts.app')

@section('content')
<script src="{{ asset('js/delivery.js') }}"></script>
<a href="{{ route('admin.search.curriculum.list', $curriculum->grade_id) }}" class="back">←戻る</a>
<div>
    <h1>配信日時設定</h1>
</div>

<div class="container-d1">
    <!-- カリキュラムのタイトルを表示 -->
    <h4>{{ $curriculum->title }}</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error-message">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.delivery.new.create', $curriculum->id) }}" method="POST">
        @csrf
        <table>

            

            <tbody id="delivery_times">
                @for($i = 0; $i < count(old('delivery_from_date', $delivery_times)); $i++)
                    <tr>
                        <td>
                            <input type="text" name="delivery_from_date[]"
                                value="{{ old('delivery_from_date.' . $i) }}"
                                placeholder="年月日">
                            @error('delivery_from_date.' . $i)
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="delivery_from_time[]"
                                value="{{ old('delivery_from_time.' . $i) }}"
                                placeholder="時分">
                            @error('delivery_from_time.' . $i)
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </td>
                        <td><h3>～</h3></td>
                        <td>
                            <input type="text" name="delivery_to_date[]"
                                value="{{ old('delivery_to_date.' . $i) }}"
                                placeholder="年月日">
                            @error('delivery_to_date.' . $i)
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" name="delivery_to_time[]"
                                value="{{ old('delivery_to_time.' . $i) }}"
                                placeholder="時分">
                            @error('delivery_to_time.' . $i)
                                <div class="error-message">{{ $message }}</div>
                            @enderror
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
@endsection