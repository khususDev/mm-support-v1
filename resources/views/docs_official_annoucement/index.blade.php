@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card p-3">
                    <div class="row ml-3 mr-3 d-flex justify-content-between">
                        <div class="title d-flex justify-content-center">
                            <h2 class="title-body">
                                Internal Document
                            </h2>
                        </div>
                        <div class="action">
                            <button class="btn btn-secondary" id="button" style="color: #333"><i class="fas fa-folder"></i>
                                Tambah Folder</button>
                        </div>
                    </div>
                </div>

                <div class="row p-3">
                    @foreach ($folders as $folder)
                        <div class="col-md-3 col-sm-4 col-6 d-flex">
                            <div class="card folder-box shadow-sm w-100 position-relative text-center p-3"
                                style="cursor:pointer; min-height: 170px;">

                                {{-- Tombol Delete --}}
                                <form action="{{ route('external_folder.delete_folder', $folder->id) }}" method="POST"
                                    class="position-absolute m-1" style="top: 0; right: 0; z-index: 10;"
                                    onsubmit="return confirm('Yakin ingin menghapus folder {{ $folder->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Hapus Folder"
                                        style="width: 30px; height: 30px; padding: 0;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                {{-- Konten Folder --}}
                                <a href="{{ route('docs_external.show', Crypt::encryptString($folder->id)) }}"
                                    class="text-decoration-none text-dark d-flex flex-column justify-content-center align-items-center h-100">
                                    <i class="fas fa-folder" style="color:#f0b429; font-size:60px;"></i>
                                    <p class="mt-2 mb-0 text-truncate w-100" title="{{ $folder->name }}">{{ $folder->name }}
                                    </p>
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

    <x-modal-folders :users="$userd" :oldUsers="old('users', [])" :location_id="$decryptID ?? null" />
@endsection

<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#button").on("click", function() {
            $("#detailModal").modal("show");
            $("#detailModal").prependTo("body");

            $("#detailModal").on("shown.bs.modal", function() {
                $("#detailModal").trigger("focus");
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {

        const selectAllCheckbox = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }

        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Check if all checkboxes are checked
                    const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

    });
</script>

<style>
    .folder-box {
        transition: all 0.2s ease;
    }

    .folder-box:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .folder-box .btn-danger {
        opacity: 0.85;
    }

    .i-folder {
        width: 50px;
        height: 50px;
        margin: auto;
    }

    .header {
        background: #f5f9ff;
        font-size: 14px;
        font-weight: bold;
    }

    body.modal-open {
        padding-right: 0 !important;
    }

    .modal-backdrop {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 1040 !important;
    }

    .modal-content {
        background-color: #fff !important;
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        top: 10%;
        left: 10%;
    }
</style>
