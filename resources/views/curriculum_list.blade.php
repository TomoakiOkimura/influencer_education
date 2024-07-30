@extends('layouts.app')

@section('content')
    {{-- 学年ボタン押下後に対応した授業を表示する非同期処理javascriptの読み込み --}}
    <script src="{{ asset('js/gradessearch.js') }}"></script>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <a href="{{ route('admin.show.curriculum.list') }}" class="back">←戻る</a>
    <h1>授業一覧</h1>
    <div class="main">
        <div class="container-1">
            <a href="{{ route('admin.show.curriculum.create') }}" class="register">新規登録</a>
            {{-- 学年のサイドバー --}}
            <ul class="grade-list">
                @foreach($grades as $grade)
                    <li class="grade-card grade-{{ $grade->id }}" data-grade-id="{{ $grade->id }}">
                        <p>{{ $grade->name }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="container-2">
            <div class="grade-title">{{ $currentGradeName }}</div>
            <section id="lesson-list">
                @foreach($curriculums as $curriculumGroup)
                    @php
                        $curriculum = $curriculumGroup->first();
                    @endphp
                    <article id="lessons">
                        @if($curriculum->thumbnail)
                            <img src="{{ asset($curriculum->thumbnail) }}" class="img">
                        @else
                            <img src="{{ asset('/storage/images/NoImage.jpg') }}" class="img">
                        @endif
                        <h4 class="curriculum-title">{{ $curriculum->title }}</h4>

                        {{-- 配信期間の表示 --}}
                        <ul class="list-unstyled">
                            @foreach($curriculumGroup as $delivery_time)
                                @if($delivery_time->delivery_from && $delivery_time->delivery_to)
                                    <li class="delivery-time">{{ Carbon\Carbon::parse($delivery_time->delivery_from)->format('n月j日 H:i') }} ~ {{ Carbon\Carbon::parse($delivery_time->delivery_to)->format('n月j日 H:i') }}</li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="linkbutton">
                            <a href="{{ route('admin.show.curriculum.edit', $curriculum->id) }}" class="btn-link">授業内容編集</a>
                            <a href="{{ route('admin.show.delivery.update', $curriculum->id) }}" class="btn-link">配信日時編集</a>
                        </div>
                    </article>
                @endforeach
            </section>
        </div>
    </div>
</div>
</html>
@endsection