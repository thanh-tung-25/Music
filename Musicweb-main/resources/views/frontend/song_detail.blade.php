@extends('layouts.frontend')

@section('content')
<div class="container mt-5">
    <h2>{{ $song->title }}</h2>
    <p><strong>Ca sĩ:</strong> {{ $song->artist->name ?? 'Không rõ' }}</p>
    <p><strong>Thể loại:</strong> {{ $song->genre->name ?? 'Không rõ' }}</p>
    <p><strong>Thời lượng:</strong> {{ $song->duration }}</p>

    <hr>

    <h5>🎧 Nghe bài hát</h5>
    @if ($song->file_url)
        <audio controls style="width: 100%;">
            <source src="{{ asset('storage/' . $song->file_url) }}" type="audio/mpeg">
            Trình duyệt của bạn không hỗ trợ audio HTML5.
        </audio>
    @else
        <p class="text-danger">Không có file nhạc.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('music.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>
</div>
@endsection
