@extends('adminlte::page')

@section('title', 'Chi tiết Bài hát')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Chi tiết Bài hát</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $song->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên bài hát</th>
                            <td>{{ $song->title }}</td>
                        </tr>
                        <tr>
                            <th>Nghệ sĩ</th>
                            <td>{{ $song->artist->name ?? 'Không xác định' }}</td>
                        </tr>
                        <tr>
                            <th>Thể loại</th>
                            <td>{{ $song->genre->name ?? 'Không xác định' }}</td>
                        </tr>
                        <tr>
                            <th>Thời lượng</th>
                            <td>{{ $song->duration }}</td>
                        </tr>
                        <tr>
                            <th>File URL</th>
                            <td>
                                <a href="{{ $song->file_url }}" target="_blank">{{ $song->file_url }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $song->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $song->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('songs.edit', $song->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('songs.destroy', $song->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa bài hát này không?')) {
            button.parentElement.submit();
        }
    }
</script>
@endsection
