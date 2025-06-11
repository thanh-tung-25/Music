@extends('layouts.frontend')

@section('content')

    <h2 class="text-3xl font-bold mb-6">🎵 Playlist: {{ $name }}</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse($songs as $song)
            <div class="bg-gray-800 rounded-lg shadow-md p-4 flex flex-col items-center transition transform hover:scale-105 duration-300">
                <div class="w-full h-48 bg-cover bg-center rounded-lg mb-4" style="background-image: url('/images/music-cover.jpg');"></div>

                <h3 class="text-xl font-semibold text-white mb-1">{{ $song->title }}</h3>
                <p class="text-sm text-gray-400">{{ $song->artist->name ?? 'Không rõ nghệ sĩ' }}</p>
                <p class="text-sm text-gray-500 mb-2">{{ $song->genre->name ?? 'Thể loại khác' }}</p>

                <audio controls class="w-full mt-4">
                    <source src="{{ $song->file_url }}" type="audio/mpeg">
                    Trình duyệt của bạn không hỗ trợ trình phát nhạc.
                </audio>
            </div>
        @empty
            <p class="text-gray-400">Không có bài hát nào trong playlist này.</p>
        @endforelse
    </div>

@endsection
