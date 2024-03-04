@extends('layouts.dashboard.app')

@section('title', 'Edit Kategori')

@section('content')

    <div class="card card-height-100">
        <!-- cardheader -->
        <div class="card-header border-bottom-dashed align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Add Category</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="mb-3">
                        <label for="category">Category Name</label>
                        <input type="text" name="name" placeholder="Category name..."
                            class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                            value="{{ $category->name }}" required>
                        <div class="invalid-feedback"> {{ $errors->first('name') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="description">Category Description</label>
                        <textarea type="text" name="description" placeholder="Category Description..."
                            class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}" required>{{ $category->description }}</textarea>
                        <div class="invalid-feedback"> {{ $errors->first('description') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="slug">Image </label>
                        <input type="file" name="image"
                            class="form-control {{ $errors->first('image') ? 'is-invalid' : '' }}">
                        <p class="text-danger">*Kosongkan jika tidak ingin diupdate</p>
                        <div class="invalid-feedback"> {{ $errors->first('image') }}</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <a href="{{ route('category.index') }}" class="btn btn-md btn-light">Back</a>
                        <button type="submit" class="btn btn-md btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <!-- Basic Input -->
            {{-- <div>
                <label for="basiInput" class="form-label">Basic Input</label>
                <input type="password" class="form-control" id="basiInput">
            </div> --}}
        </div>
    </div>
@endsection
