@extends('layouts.app')

@section('content')
<div class="container">
    @if($curriculum->always_delivery_flg || ($curriculum->start_date <= now() && $curriculum->end_date >= now()))
        <!-- 動画表示部分 -->
        <div class="video-container">
            <video controls>
                <source src="{{ $curriculum->video_url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- 学年表示部分 -->
        <div class="grade">
            学年: {{ $curriculum->grade->name }}
        </div>

        <!-- 授業タイトル表示部分 -->
        <div class="title">
            授業タイトル: {{ $curriculum->title }}
        </div>

        <!-- 講座内容表示部分 -->
        <div class="description">
            講座内容: {{ $curriculum->description }}
        </div>

        <!-- 受講しましたボタン -->
        <div class="complete-button">
            @if($curriculum->start_date <= now() && $curriculum->end_date >= now())
                <button id="complete-button" class="btn btn-primary" onclick="markAsCompleted({{ $curriculum->id }})">
                    受講しました
                </button>
            @endif
        </div>
    @else
        <!-- 配信期間外のメッセージ表示部分 -->
        <div class="alert alert-warning">
            この授業は現在配信されていません。
        </div>
    @endif
</div>

<script>
    function markAsCompleted(curriculumId) {
        // 非同期でカリキュラムのクリア登録を行う処理を追加します
        fetch('/curriculum/complete/' + curriculumId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('complete-button').innerText = '受講済';
                document.getElementById('complete-button').classList.add('btn-success');
                document.getElementById('complete-button').disabled = true;
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
