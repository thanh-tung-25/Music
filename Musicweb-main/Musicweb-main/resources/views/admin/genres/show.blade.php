@extends('adminlte::page')

@section('title', 'Chi tiết Thể loại')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Chi tiết Thể loại</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('genres.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">ID</th>
                    <td>{{ $genre->id }}</td>
                </tr>
                <tr>
                    <th>Tên thể loại</th>
                    <td>{{ $genre->name }}</td>
                </tr>
                <tr>
                    <th>Mô tả</th>
                    <td>{{ $genre->description }}</td>
                </tr>
                <tr>
                    <th>Số bài hát</th>
                    <td>{{ $genre->songs->count() }}</td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td>{{ $genre->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Cập nhật lần cuối</th>
                    <td>{{ $genre->updated_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($genre->songs->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Danh sách bài hát</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bài hát</th>
                        <th>Nghệ sĩ</th>
                        <th>Thời lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genre->songs as $song)
                    <tr>
                        <td>{{ $song->id }}</td>
                        <td>{{ $song->title }}</td>
                        <td>{{ $song->artist->name ?? 'Không xác định' }}</td>
                        <td>{{ $song->duration }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa thể loại này không?')) {
            button.parentElement.submit();
        }
    }
</script>
@endsection
