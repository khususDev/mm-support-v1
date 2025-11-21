@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sys_menu.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">Edit Master Menu</h6>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="kategori">Menu Categori</label>
                                                <select class="form-control" name="kategori" id="kategori">
                                                    <option value="" hidden>Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $data->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Menu
                                                    Name</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="name" value="{{ $data->name }}" />
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Ordinal
                                                    Number</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="urut" value="{{ $data->no_urut }}" />
                                                @error('urut')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">URL</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="url" value="{{ $data->url }}" />
                                                @error('url')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Parent</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="parent" value="{{ $data->parent_id }}" />
                                                @error('parent')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div style="display: flex; flex-direction: column; gap: 5px;">
                                                    <label class="form-label">Menu Icon</label>
                                                    <button type="button" id="toggle-icon-picker"
                                                        class="btn btn-secondary mb-3" style="width: 150px"><i
                                                            class="fas fa-search-location"> Pilih</i>
                                                    </button>
                                                </div>

                                                <div>
                                                    <input id="icon-input" name="icon" type="text"
                                                        class="form-control mb-3" placeholder="Pilih ikon..." readonly>
                                                </div>
                                            </div>

                                            <a href="{{ route('sys_menu.index') }}" class="btn btn-danger">Batal</a>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .iconpicker-popover.popover {
            width: auto;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Document ready. Initializing iconpicker...');

            $('#icon-input').iconpicker({
                icon: 'fas fa-smile',
                rows: 7,
                cols: 6,
                placement: 'inline',
                hideOnSelect: true
            });

            $('#toggle-icon-picker').on('click', function() {
                const iconPickerContainer = $('#icon-input').parent();
                if (iconPickerContainer.is(':visible')) {
                    iconPickerContainer.hide();
                } else {
                    iconPickerContainer.show();
                    if ($('.iconpicker-popover').length === 0) {
                        $('#icon-input').iconpicker('update');
                    }
                }
            });

            $('#icon-input').parent().hide();
        });
    </script>
@endpush
