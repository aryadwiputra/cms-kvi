@extends('layouts.dashboard.app')

@section('title', 'Edit Artikel')

@section('content')

    <div class="card card-height-100">
        <!-- cardheader -->
        <div class="card-header border-bottom-dashed align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Add Article</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="col-12">
                    {{-- Erros message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="title" class="font-weight-bold">Title</label>
                        <input type="text" name="title" placeholder="Article Title"
                            class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}"
                            value="{{ $article->title }}" required>
                        <div class="invalid-feedback"> {{ $errors->first('title') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="font-weight-bold">Category</label>
                        <select class="form-control" id="category" name="category" data-choices data-choices-removeItem>
                            @foreach ($categories as $category)
                                @if (!blank($category->name))
                                    <option value="{{ $category->id }}"
                                        {{ $article->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="font-weight-bold">Content</label>
                        <textarea id="content" class="ckeditor-classic" name="content" rows="10" cols="50">
                            {{ $article->content }}
                        </textarea>
                    </div>
                    <div class="mb-3 mt-4 d-flex flex-wrap gap-2">
                        <button class="btn btn-secondary" name="save_action" value="DRAFT">Save as draft</button>
                        <button class="btn btn-success" name="save_action" value="PUBLISH">Publish</button>
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

@push('plugin-script')
    <script src="{{ asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endpush
