@extends('adminlte::page')

@section('title', 'Quản lý Nghệ sĩ')

@section('content_header')
<h1>Quản lý Nghệ sĩ</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Danh sách Nghệ sĩ</h3>
            <a href="{{ route('artists.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Form tìm kiếm -->
        <form action="{{ route('artists.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm..." value="{{ $keyword }}">
                </div>
                <div class="col-md-2">
                    <select name="search_by" class="form-control">
                        @foreach($searchOptions as $value => $label)
                        <option value="{{ $value }}" {{ $searchBy === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort_by" class="form-control">
                        @foreach($sortOptions as $value => $label)
                        <option value="{{ $value }}" {{ $sortBy === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-control">
                        @foreach($perPageOptions as $value => $label)
                        <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Làm mới
                    </a>
                </div>
            </div>
        </form>

        <!-- Bảng dữ liệu -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Avatar</th>
                        <th>Tên nghệ sĩ</th>
                        <th>Tiểu sử</th>
                        <th width="10%">Số bài hát</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artists as $artist)
                    <tr>
                        <td>{{ $artist->id }}</td>
                        <td>
                            @if($artist->avatar)
                            <img src="{{ secure_asset('storage/' . $artist->avatar) }}" alt="{{ $artist->name }}" class="img-thumbnail" style="max-height: 50px;">
                            @else
                            <img src="{{ secure_asset('images/no-avt.jpg') }}" alt="{{ $artist->name }}" class="img-thumbnail" style="max-height: 50px;">
                            @endif
                        </td>
                        <td>{{ $artist->name }}</td>
                        <td>{{ Str::limit($artist->bio, 100) }}</td>
                        <td>{{ $artist->songs_count }}</td>
                        <td>
                            <a href="{{ route('artists.show', $artist->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('artists.edit', $artist->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('artists.destroy', $artist->id) }}"
                                method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop