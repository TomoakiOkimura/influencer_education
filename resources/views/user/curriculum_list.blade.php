@extends('user.layouts.app')

@section('content')

<div class="container">
    <div class="row">
      <div >
        <label for="profile_image">
          <img src="{{ asset('storage/' . $user->profile_image) }}" alt="商品画像" class="profile_image">
        </label>

        <label for="name">
          <div class="form-group">{{ $user->name }}さんの授業進捗</div><br>
          <div class="form-group">現在の学年：{{ $user->grade->name }}</div>
        </label>
      </div>


      <div class="col col-md-4">
        <nav class="panel panel-default">
          <div class="panel-heading">学年</div>
          <div class="list-group">
          <a href="{{ route('user.curriculum_list') }}" class="list-group-item">学年一覧</a>
          @foreach($grades as $grade)
          <a href="{{ route('user.curriculum_list', ['id' => $grade->id]) }}" class="list-group-item">
            {{ $grade->name }}</a>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="curriculum-container column col-md-8">
      @foreach($curriculums as $curriculum)
      <div class="curriculum-block">
        @if(isset($curriculum_progress[$curriculum->id]) && $curriculum_progress[$curriculum->id]->clear_flg == 1)
        <a class="curriculum_title"  href="{{ $curriculum->video_url }}">{{ $curriculum->title }}</a>
        <div>受講済み</div>
        @else
        <span class="disabled">{{ $curriculum->title }}</span>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
