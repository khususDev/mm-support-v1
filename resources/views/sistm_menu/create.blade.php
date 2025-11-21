@extends('layouts.main')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sys_menu.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">Tambah Master Menu</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Menu Categori</label>
                                            <select class="form-control" name="kategori" id="kategori">
                                                <option value="" selected hidden>Pilih Kategori</option>
                                                @foreach ($categori as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Parent Menu</label>
                                            <select class="form-control" name="parent" id="parent">
                                                <option value="" selected hidden>Pilih Menu</option>
                                                @foreach ($menu as $menus)
                                                    <option value="{{ $menus->id }}">{{ $menus->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menu Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">URL (sample: /name_url)</label>
                                            <input type="text" class="form-control" name="url"
                                                value="{{ old('url') }}">
                                            @error('url')
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
                                    </div>
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
