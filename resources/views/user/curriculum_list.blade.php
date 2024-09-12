@extends('user.layouts.app')

@section('content')

<div class="container">
    <div class="row">
      <div class="col col-md-4">
        <nav class="panel panel-default">
          <div class="panel-heading">学年</div>
          <div class="list-group">
          @foreach($grades as $grade)
          <a href="{{ route('user.curriculum_list', ['id' => $grade->id]) }}" class="list-group-item">
            {{ $grade->name }}</a>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="curriculum-container column col-md-8">
      @foreach($curriculums as $curriculum)
      <div class="curriculum-block">{{ $curriculum->title }}
        @if($curriculum->clear_flag == 1)
        <span class="badge badge-success">受講済み</span>
        @endif
      </div>
      @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
