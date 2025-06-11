@extends('layouts.frontend')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-yellow-400">🎤 Danh sách nghệ sĩ</h2>

    @if($artists->isEmpty())
        <p class="text-gray-400">Không có nghệ sĩ nào được tìm thấy.</p>
    @else
        <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-6">
            @foreach($artists as $artist)
                <div class="bg-gray-800 p-6 rounded-lg text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                    {{-- Avatar hình ảnh nếu có, nếu không thì hiển thị chữ cái đầu --}}
                    @if($artist->avatar_url)
                        <img src="{{ asset('storage/' . $artist->avatar_url) }}"
                             alt="{{ $artist->name }}"
                             class="w-24 h-24 mx-auto rounded-full object-cover mb-4 border-4 border-purple-500 shadow">
                    @else
                        <div class="w-24 h-24 mx-auto rounded-full bg-purple-600 text-white flex items-center justify-center text-3xl font-bold mb-4 shadow">
                            {{ strtoupper(substr($artist->name, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Tên nghệ sĩ --}}
                    <h3 class="text-lg font-semibold text-white">{{ $artist->name }}</h3>

                    {{-- Quốc gia --}}
                    <p class="text-sm text-gray-400 mb-3">
                        🌍 {{ $artist->country ?? 'Không rõ quốc gia' }}
                    </p>

                    {{-- Nút chi tiết --}}
                    <a href="{{ route('artist.show', $artist->id) }}"
                       class="inline-block mt-2 px-4 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600 text-sm transition">
                        🔍 Xem chi tiết
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
