@extends('adminlte::page')

@section('title', 'Chỉnh Sửa Thể Loại')

@section('content_header')
<h1>Chỉnh Sửa Thể Loại</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('genres.update', $genre->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Tên thể loại <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-music"></i>
                                </span>
                            </div>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $genre->name) }}" placeholder="Nhập tên thể loại" required>
                        </div>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-align-left"></i>
                                </span>
                            </div>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4" placeholder="Nhập mô tả thể loại">{{ old('description', $genre->description) }}</textarea>
                        </div>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{ route('genres.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop