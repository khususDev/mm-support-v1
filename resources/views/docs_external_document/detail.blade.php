@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card p-3">
                    <div class="row pl-1 mr-3 d-flex justify-content-between">
                        <div class="top-left d-flex ml-2">
                            <a href="{{ route('docs_external.index') }}" class="btn btn-light rounded shadow"
                                style="background-color: #ffffff">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>

                        <div class="title d-flex">
                            <h2 class="title-body ml-3 mt-1">
                                External Document
                            </h2>
                        </div>

                        <div class="action">
                            {{-- <button data-bs-toggle="modal" data-bs-target="#detailModal" id="button">Modal</button> --}}
                            <button class="btn btn-secondary" id="button-folder" style="color:#333"><i
                                    class="fas fa-plus-square"></i> Tambah Folder</button>
                            <button class="btn btn-primary ml-2" id="button-file" style="color:#f1eded"><i
                                    class="fas fa-file"></i> Tambah File</button>
                        </div>
                    </div>
                </div>

                @if ($subfolders->isEmpty() && $files->isEmpty())
                    <div class="row p-5">
                        <div class="col-12 text-center text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2" id="icons"></i>
                            <p class="mb-0" id="teks">Belum ada file atau folder</p>
                        </div>
                    </div>
                @endif

                <div class="row p-3">
                    @foreach ($subfolders as $subfolder)
                        <div class="col-md-3 col-sm-4 col-6 mb-4">
                            <div class="card folder-box shadow-sm w-100 position-relative text-center p-3"
                                style="cursor:pointer; min-height: 170px;">
                                {{-- Tombol Delete --}}
                                <form action="{{ route('external_folder.delete_folder', $subfolder->id) }}" method="POST"
                                    class="position-absolute m-1" style="top: 0; right: 0; z-index: 10;"
                                    onsubmit="return confirm('Yakin ingin menghapus folder {{ $subfolder->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Hapus Folder"
                                        style="width: 30px; height: 30px; padding: 0;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                <a href="{{ route('docs_external.show', Crypt::encryptString($subfolder->id)) }}"
                                    class="text-decoration-none text-dark">
                                    <div class="card text-center shadow-s p-3 folder-box" style="cursor:pointer;">
                                        <i class="fas fa-folder fa-3x" style="color:#f0b429; font-size:10vh;"></i>
                                        <p class="mt-2 mb-0 text-truncate">{{ $subfolder->name }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row p-3">
                    @foreach ($files as $file)
                        @php
                            $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
                            $iconMap = [
                                'pdf' => 'pdf.svg',
                                'doc' => 'docx.svg',
                                'docx' => 'docx.svg',
                                'xls' => 'xlsx.svg',
                                'xlsx' => 'xlsx.svg',
                                'jpg' => 'jpg.svg',
                                'jpeg' => 'jpg.svg',
                                'png' => 'png.svg',
                            ];
                            $iconFile = $iconMap[$extension] ?? 'default.svg';
                        @endphp

                        <div class="col-md-3 col-sm-4 col-6 d-flex">
                            <div class="card text-center shadow-s folder-box w-100 position-relative p-3"
                                style="min-height: 180px;">

                                {{-- Tombol Delete --}}
                                <form action="{{ route('docs_external.delete_file', $file->id) }}" method="POST"
                                    class="position-absolute m-1" style="top: 0; right: 0; z-index: 10;"
                                    onsubmit="return confirm('Yakin ingin menghapus file {{ $file->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Hapus File"
                                        style="width: 30px; height: 30px; padding: 0;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                {{-- Konten File --}}
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                    <img src="{{ asset('assets/img/icon/' . $iconFile) }}" alt="{{ $extension }} icon"
                                        style="width: 60px; height: 60px;">
                                    <p class="mt-2 mb-1 text-truncate w-100" title="{{ $file->name }}">
                                        {{ $file->name }}</p>

                                    {{-- Tombol Download --}}
                                    <a href="{{ route('docs_external.download', $file->id) }}"
                                        class="btn btn-sm btn-outline-primary mt-1" title="Download">
                                        <i class="fas fa-download" style="font-size: 24px"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <div class="card">
                    <ul>
                        @foreach ($subfolders as $subfolder)
                            <li>
                                <a href="{{ route('docs_external.show', Crypt::encryptString($subfolder->id)) }}">📁
                                    {{ $subfolder->name }}</a>
                            </li>
                        @endforeach
                        @foreach ($files as $file)
                            <li>📄 {{ $file->name }}</li>
                        @endforeach
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Modal Upload File -->
    <x-modal-files :users="$userd" :oldUsers="old('users', [])" :location_id="$decryptID ?? null" />
    <x-modal-folders :users="$userd" :oldUsers="old('users', [])" :location_id="$decryptID ?? null" />
@endsection

<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#button-folder").on("click", function() {
            $("#detailModal").modal("show");
            $("#detailModal").prependTo("body");

            $("#detailModal").on("shown.bs.modal", function() {
                $("#detailModal").trigger("focus");
            });
        });
    });
    $(document).ready(function() {
        $("#button-file").on("click", function() {
            $("#uploadModal").modal("show");
            $("#uploadModal").prependTo("body");

            $("#uploadModal").on("shown.bs.modal", function() {
                $("#uploadModal").trigger("focus");
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
    #icons {
        font-size: 10vh;
    }

    #teks {
        margin-top: 10px;
        font-size: 5vh;
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
