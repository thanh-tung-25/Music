@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Bảng Điều Khiển</h1>
@endsection

@section('content')
<div class="row">
    <!-- Card Tổng số Người dùng -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $userCount }}</h3>
                <p>Người Dùng</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('admin/users') }}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Card Tổng số Bài hát -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $songCount }}</h3>
                <p>Bài Hát</p>
            </div>
            <div class="icon">
                <i class="fas fa-music"></i>
            </div>
            <a href="{{ url('admin/songs') }}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Card Tổng số Nghệ sĩ -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $artistCount }}</h3>
                <p>Nghệ Sĩ</p>
            </div>
            <div class="icon">
                <i class="fas fa-microphone"></i>
            </div>
            <a href="{{ url('admin/artists') }}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Card Tổng số Thể loại -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $genreCount }}</h3>
                <p>Thể Loại</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
            <a href="{{ url('admin/genres') }}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Danh sách bài hát -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh Sách Bài Hát Mới Nhất</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu Đề</th>
                            <th>Nghệ Sĩ</th>
                            <th>Thể Loại</th>
                            <th>Thời Lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Song::latest()->take(5)->get() as $song)
                        <tr>
                            <td>{{ $song->id }}</td>
                            <td>{{ $song->title }}</td>
                            <td>{{ $song->artist->name }}</td>
                            <td>{{ $song->genre->name }}</td>
                            <td>{{ gmdate("i:s", $song->duration) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection