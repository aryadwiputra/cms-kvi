@extends('layouts.dashboard.app')

@section('title', 'Add Destination')

@section('content')

    <div class="card card-height-100">
        <!-- cardheader -->
        <div class="card-header border-bottom-dashed align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Add Destination</h4>
        </div>

        <div class="card-body">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('destination.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <div class="mb-3">
                        <label for="category">Title</label>
                        <input type="text" name="title" placeholder="Title name..."
                            class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}"
                            value="{{ old('title') }}" required>
                        <div class="invalid-feedback"> {{ $errors->first('title') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="description">Content</label>
                        <textarea id="content" class="ckeditor-classic" name="content" rows="10" cols="50"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="slug">Image</label>
                        <input type="file" name="image"
                            class="form-control {{ $errors->first('image') ? 'is-invalid' : '' }}" required>
                        <div class="invalid-feedback"> {{ $errors->first('image') }}</div>
                    </div>
                    <div class="mb-3 mt-4 d-flex flex-wrap gap-2">
                        <button class="btn btn-secondary" name="save_action" value="DRAFT">Save as draft</button>
                        <button class="btn btn-success" name="save_action" value="PUBLISH">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('plugin-script')
    <script src="{{ asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endpush
