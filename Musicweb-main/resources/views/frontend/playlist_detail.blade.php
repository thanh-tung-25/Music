@extends('layouts.frontend')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-purple-400">🎵 Playlist: {{ $playlist->name }}</h2>

    @if($playlist->songs->isEmpty())
        <p class="text-gray-400">Playlist chưa có bài hát nào.</p>
    @else
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($playlist->songs as $song)
                <div class="bg-gray-800 rounded-lg shadow-md p-4 flex flex-col items-center hover:scale-105 transition duration-300">
                    <div class="w-full h-48 bg-cover bg-center rounded-lg mb-4" style="background-image: url('/images/music-cover.jpg');"></div>

                    <h3 class="text-xl font-semibold text-white mb-1">{{ $song->title }}</h3>
                    <p class="text-sm text-gray-400">{{ $song->artist->name ?? 'Không rõ nghệ sĩ' }}</p>
                    <p class="text-sm text-gray-500 mb-2">{{ $song->genre->name ?? 'Thể loại khác' }}</p>

                    <audio controls class="w-full mt-2">
                        <source src="{{ asset('storage/' . $song->file_url) }}" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ trình phát nhạc.
                    </audio>

                    <a href="{{ route('music.show', $song->id) }}"
                       class="mt-3 text-sm text-purple-300 hover:underline">
                        ▶️ Xem chi tiết
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
