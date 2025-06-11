@extends('layouts.frontend')

@section('content')

    <h2 class="text-3xl font-bold mb-6">Danh sách bài hát</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($songs as $song)
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
        @endforeach
    </div>

    <div class="mt-10">
        <h2 class="text-3xl font-bold mb-4">Playlist nổi bật</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-purple-700 p-6 rounded-lg shadow-lg text-white hover:bg-purple-800 transition">
                <h3 class="text-2xl font-bold mb-2">🎧 Chill Vibes</h3>
                <p class="text-sm text-purple-100">Âm nhạc thư giãn mỗi ngày.</p>
            </div>
            <div class="bg-blue-700 p-6 rounded-lg shadow-lg text-white hover:bg-blue-800 transition">
                <h3 class="text-2xl font-bold mb-2">🔥 Trending</h3>
                <p class="text-sm text-blue-100">Top hit đang hot nhất hiện nay.</p>
            </div>
            <div class="bg-pink-600 p-6 rounded-lg shadow-lg text-white hover:bg-pink-700 transition">
                <h3 class="text-2xl font-bold mb-2">💔 Buồn Lặng</h3>
                <p class="text-sm text-pink-100">Những giai điệu sâu lắng cho tâm trạng.</p>
            </div>
        </div>
    </div>

@endsection
