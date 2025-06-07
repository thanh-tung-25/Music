@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Thêm Bài Hát</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('songs.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Tên bài hát</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="artist_id">Nghệ sĩ</label>
                    <select name="artist_id" class="form-control" required>
                        <option value="">-- Chọn nghệ sĩ --</option>
                        @foreach($artists as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="genre_id">Thể loại</label>
                    <select name="genre_id" class="form-control" required>
                        <option value="">-- Chọn thể loại --</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="file_url">URL Bài Hát</label>
                    <input type="url" name="file_url" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="duration">Thời lượng (giây)</label>
                    <input type="number" name="duration" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection
