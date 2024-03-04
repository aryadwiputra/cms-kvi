@extends('layouts.dashboard.app')

@section('title', 'Kategori')

@section('content')
    <div class="card card-height-100 table-responsive">
        <!-- cardheader -->
        <div class="card-header border-bottom-dashed align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Category</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('category.create') }}" class="btn btn-soft-primary btn-sm">
                    <i class="ri-add-line"></i>Add
                </a>
            </div>
        </div>


        <!-- Hoverable Rows -->
        <table class="table table-hover table-nowrap mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Image</th>
                    <th scope="col" class="col-1">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset('category_image/' . $category->image) }}" alt="" width="100px">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <div class="hstack gap-3 flex-wrap">
                                <a href="{{ route('category.edit', $category->id) }}" class="link-success fs-15"><i
                                        class="ri-edit-2-line"></i></a>

                                <form id="delete-form-{{ $category->id }}"
                                    action="{{ route('category.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <a onclick="deleteData('{{ $category->id }}')" class="link-danger fs-15"><i
                                            class="ri-delete-bin-line"></i></a>
                                </form>
                            </div>
                            {{-- <div class="dropdown">
                                <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a href="{{ route('category.edit', $category->id) }}" class="dropdown-item">
                                            Edit</a>
                                    </li>
                                    <li>

                                        <form id="delete-form-{{ $data->id }}"
                                            action="{{ route('mapel.destroy', $data->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('mapel.edit', Crypt::encrypt($data->id)) }}"
                                                class="btn btn-success">Edit</a>
                                            <button class="btn btn-danger"
                                                onclick="deleteMapel('{{ $data->id }}')">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="5" class="text-center">No data to display</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="card-footer py-4">
            <nav aria-label="..." class="pagination justify-content-end">
                {{ $categories->links() }}
            </nav>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-12">
            {{-- Jika ada flash session message --}}
    @if (session()->has('success'))
        <div class=" alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="alert-content">
                <p>
                    {{ session()->get('success') }}
                </p>
                <button type="button" class="btn-close text-capitalize" data-bs-dismiss="alert" aria-label="Close">
                    <img src="{{ asset('admin/img/svg/x.svg') }}" alt="x" class="svg" aria-hidden="true">
                </button>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                cancelButtonClass: 'btn btn-danger w-xs mt-2',
                // confirmButtonColor: '#d33',
                // cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
