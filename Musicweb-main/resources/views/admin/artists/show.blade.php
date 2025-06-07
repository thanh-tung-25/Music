@extends('adminlte::page')

@section('title', 'Chi tiết Nghệ sĩ')

@section('content_header')
<h1>Chi tiết Nghệ sĩ</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('artists.edit', $artist->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($artist->avatar)
                        <img src="{{ secure_asset('storage/' . $artist->avatar) }}" 
                             alt="{{ $artist->name }}" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 300px;">
                    @else
                        <img src="{{ secure_asset('images/no-avt.jpg') }}" 
                             alt="{{ $artist->name }}" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 300px;">
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $artist->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên nghệ sĩ</th>
                            <td>{{ $artist->name }}</td>
                        </tr>
                        <tr>
                            <th>Tiểu sử</th>
                            <td>{{ $artist->bio }}</td>
                        </tr>
                        <tr>
                            <th>Số bài hát</th>
                            <td>{{ $artist->songs_count }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $artist->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $artist->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($artist->songs->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Danh sách bài hát</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bài hát</th>
                                    <th>Thể loại</th>
                                    <th>Lượt nghe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artist->songs as $song)
                                <tr>
                                    <td>{{ $song->id }}</td>
                                    <td>{{ $song->title }}</td>
                                    <td>{{ $song->genre->name ?? 'N/A' }}</td>
                                    <td>{{ $song->plays_count ?? 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table th {
        background-color: #f4f6f9;
    }
</style>
@stop
