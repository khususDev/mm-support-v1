@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-3">
                    <div class="row ml-3 mr-3">
                        <div class="title d-flex">
                            <i class="fas fa-journal-whills mt-2" style="color: #020d71; font-size: 20px;"></i>
                            <h2 class="title-body ml-3 mt-1">
                                Manual Mutu
                            </h2>
                        </div>

                    </div>
                </div>

                <form action="{{ route('docs_qualitymanual.store') }}" method="POST" enctype="multipart/form-data"
                    id="formData">
                    @csrf
                    {{-- Card: Overview --}}
                    <div class="card m-4 shadow">
                        <div class="title">
                            <p>Data Document</p>
                        </div>
                        <div class="card-body">
                            <div class="row p-0">
                                <div class="col-6 d-flex justify-content-between p-0">
                                    <div class="form-group col-8">
                                        <label class="form-label" style="color: dodgerblue">No Dokumen</label>
                                        <input type="text" class="form-control force-disabled" id="no_dokumen"
                                            aria-describedby="defaultFormControlHelp" name="no_dokumen"
                                            style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                                            disabled value="{{ old('no_dokumen', $data->no_document ?? '') }}" />
                                    </div>
                                    <div class="form-group col-4">
                                        <label class="form-label" style="color: dodgerblue">Revisi</label>
                                        <input type="text" class="form-control" name="no_revisi" id="no_revisi"
                                            aria-describedby="defaultFormControlHelp"
                                            style="font-size: large; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                                            disabled value="{{ old('no_revisi', $data->revisi ?? '') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label" style="color: dodgerblue">Nama Dokumen</label>
                                <input type="text"
                                    class="form-control text-uppercase @error('namadocs') is-invalid @enderror"
                                    aria-describedby="defaultFormControlHelp"
                                    style="font-size: large; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                                    id="nama_dokumen" name="nama_dokumen"
                                    value="{{ old('nama_dokumen', $data->nama_document ?? '') }}"
                                    oninput="this.value = this.value.toUpperCase()">
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label" style="color: dodgerblue">Nama Perusahaan</label>
                                <input type="text"
                                    class="form-control text-uppercase @error('perusahaan') is-invalid @enderror"
                                    aria-describedby="defaultFormControlHelp"
                                    style="font-size: large; font-family: Verdana, Geneva, Tahoma, sans-serif;"
                                    id="perusahaan" name="perusahaan"
                                    value="{{ old('perusahaan', $data->perusahaan ?? '') }}"
                                    oninput="this.value = this.value.toUpperCase()">
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label" style="color: dodgerblue">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"
                                    onblur="formatProperCase(this)"
                                    style="font-size: large; font-family: Verdana, Geneva, Tahoma, sans-serif; height: 100px;">{{ old('alamat', $data->alamat ?? '') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-6 d-flex justify-content-between p-0">
                                    <div class="form-group col-6">
                                        <label for="" class="form-label" style="color: dodgerblue">Dibuat
                                            Oleh</label>
                                        <input type="text" class="form-control force-disabled" id="created"
                                            aria-describedby="defaultFormControlHelp" name="created" disabled
                                            style="font-size: 14px" value="{{ old('created', $data->uname1 ?? '') }}" />
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="" class="form-label" style="color: dodgerblue">Diperiksa
                                            Oleh</label>
                                        <select class="form-control" name="checker" id="selectlist" style="font-size: 14px">
                                            <option value="" hidden>-- Pilih --</option>

                                            @foreach ($userd as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('checker', $data->checker) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Distribusi --}}
                    <div class="card m-4 shadow">
                        <div class="title">
                            <p>Document Distribusi</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="mb-2" id="custom">
                                    <div class="left">
                                        <input type="checkbox" id="selectAll" />
                                        <label for="selectAll" style="font-weight: bold;">Pilih Semua</label>
                                    </div>
                                </div>
                                <div class="user-checkbox-list"
                                    style="border: 1px solid #ced4da; border-radius: 5px; max-height: auto; overflow-y: auto; padding: 10px;">
                                    @foreach ($users as $position => $userGroup)
                                        <div class="title" style="font-weight: bold">{{ $position }}</div>
                                        <div class="checkbox-grid d-flex flex-wrap">
                                            @foreach ($userGroup as $user)
                                                <div class="form-check d-flex m-3 align-items-center">
                                                    <input class="form-check-input user-checkbox" type="checkbox"
                                                        name="distribusi_users[]" value="{{ $user->id }}"
                                                        id="user{{ $user->id }}"
                                                        @if (isset($distribusi[$user->id])) checked @endif>
                                                    <label class="form-check-label ms-2 d-flex align-items-center"
                                                        style="font-size: 14px" for="user{{ $user->id }}">
                                                        @if (isset($distribusi[$user->id]) && $distribusi[$user->id]['avatar'])
                                                            <img src="{{ asset('assets/img/avatar/' . $distribusi[$user->id]['avatar']) }}"
                                                                alt="avatar" class="rounded-circle me-2 mr-1"
                                                                width="30" height="30">
                                                        @endif
                                                        {{ $user->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Document Files --}}
                    <div class="card m-4 shadow">
                        <div class="title">
                            <p>Document Files</p>
                        </div>
                        <div class="card-body">
                            {{-- Tab Header --}}
                            <ul class="nav nav-tabs mb-3" id="customFieldTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="kebijakan-tab" data-bs-toggle="tab"
                                        data-bs-target="#kebijakan" type="button" role="tab">Kebijakan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sasaran-tab" data-bs-toggle="tab"
                                        data-bs-target="#sasaran" type="button" role="tab">Sasaran</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="organisasi-tab" data-bs-toggle="tab"
                                        data-bs-target="#organisasi" type="button" role="tab">Organisasi</button>
                                </li>
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="kebijakan" role="tabpanel"
                                    aria-labelledby="kebijakan-tab">
                                    @include('docs_quality_manual.tab_edit.kebijakan')
                                </div>

                                <div class="tab-pane fade" id="sasaran" role="tabpanel" aria-labelledby="sasaran-tab">
                                    @include('docs_quality_manual.tab_edit.sasaran')
                                </div>

                                <div class="tab-pane fade" id="organisasi" role="tabpanel"
                                    aria-labelledby="organisasi-tab">
                                    @include('docs_quality_manual.tab_edit.organisasi')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-success btn-lg bt-submit">
                            <div class="isi d-flex justify-content-center m-2">
                                <i class="fas fa-save"></i>
                                <p>Simpan</p>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
    }

    .file-card {
        position: relative;
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: 0.2s ease-in-out;
        min-width: 0;
        /* penting agar wrap di grid */
    }

    .file-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .file-link {
        width: 100%;
        text-decoration: none;
        color: inherit;
    }

    .file-icon {
        width: 100%;
        max-width: 70px;
        height: auto;
        object-fit: contain;
        margin-bottom: 6px;
    }

    .file-title {
        font-size: 13px;
        font-weight: bold;
        line-height: 1.3;
        max-height: 3.9em;
        /* 3 lines */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        word-break: break-word;
        padding-top: 4px;
        width: 100%;
    }

    .delete-btn {
        background-color: transparent;
        border: none;
        color: #dc3545;
        /* Ukuran icon lebih besar */
        cursor: pointer;
        padding: 6px;
        line-height: 1;
        position: absolute;
        right: 8px;
        top: 8px;
    }

    .delete-btn .icon-delete {
        font-size: 16px;
        color: red;
    }

    .title p {
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-size: 14px;
        font-weight: bold;
        margin-left: 20px;
        margin-top: 10px;
    }

    .bt-submit {
        margin: 5vh;
        width: 30vh;
        height: 10vh;
        font-size: 20px;
    }

    .bt-submit i {
        font-size: 20px;
        margin-top: 5px;
    }

    .isi p {
        margin-left: 10px;
        font-size: 20px;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM dijalankan");
        const selectAllCheckbox = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }

        document.getElementById('alamat').addEventListener('input', function(e) {
            const cursorPos = this.selectionStart;
            const originalValue = this.value;

            this.value = formatToProperCase(originalValue);

            // Kembalikan cursor ke posisi semula
            this.setSelectionRange(cursorPos, cursorPos);
        });

        function formatToProperCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
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

        const deleteButtons = document.querySelectorAll('#btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Mencegah submit form langsung
                event.preventDefault();

                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika konfirmasi 'Ya', submit form
                        form.submit();
                    }
                });
            });
        });

        function handleFilePreview(inputId, previewId, countId, fileArrayName) {
            let selectedFiles = [];

            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const count = document.getElementById(countId);

            input.addEventListener('change', function() {
                const files = Array.from(this.files);
                selectedFiles = selectedFiles.concat(files);
                renderPreview();
            });

            function renderPreview() {
                preview.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const fileType = file.type;
                    const isImage = fileType.startsWith("image/");
                    const ext = file.name.split('.').pop().toLowerCase();

                    let icon = '';
                    if (isImage) {
                        icon =
                            `<img src="${URL.createObjectURL(file)}" class="rounded" style="width: 30px; height: 30px; object-fit: cover;">`;
                    } else {
                        let iconPath = '';
                        switch (ext) {
                            case 'pdf':
                                iconPath = "{{ asset('assets/img/icon/pdf.svg') }}";
                                break;
                            case 'doc':
                            case 'docx':
                                iconPath = "{{ asset('assets/img/icon/docx.svg') }}";
                                break;
                            case 'xls':
                            case 'xlsx':
                                iconPath = "{{ asset('assets/img/icon/xlsx.svg') }}";
                                break;
                            case 'png':
                            case 'jpg':
                            case 'jpeg':
                                iconPath = "{{ asset('assets/img/icon/image.svg') }}";
                                break;
                            default:
                                iconPath = "{{ asset('assets/img/icon/file.svg') }}";
                        }
                        icon =
                            `<img src="${iconPath}" class="rounded" style="width: 50px; height: 50px; object-fit: contain;">`;
                    }

                    const item = document.createElement("div");
                    item.className =
                        "d-flex align-items-center justify-content-between mb-1 bg-light rounded px-2 py-1";
                    item.style.minHeight = '50px'; // Tinggi minimal setiap item
                    item.innerHTML = `
<div class="d-flex align-items-center gap-2" style="flex:1; min-width:0;">
    ${icon}
    <a href="${URL.createObjectURL(file)}" target="_blank" 
       style="font-size:14px; margin-left:10px;
              white-space: normal;
              word-break: break-word;
              overflow: hidden;
              text-overflow: ellipsis;
              display: -webkit-box;
              -webkit-line-clamp: 2;
              -webkit-box-orient: vertical;
              flex:1;">
       ${file.name}
    </a>
</div>
<button type="button" class="btn btn-sm btn-danger" data-index="${index}">&times;</button>
`;
                    preview.appendChild(item);
                });

                count.innerText = `${selectedFiles.length} file${selectedFiles.length > 1 ? 's' : ''}`;

                preview.querySelectorAll("button").forEach(button => {
                    button.addEventListener("click", function() {
                        const index = parseInt(this.getAttribute("data-index"));
                        selectedFiles.splice(index, 1);
                        renderPreview();
                    });
                });
            }
            window[fileArrayName] = () => selectedFiles;
        }

        // Init per group
        handleFilePreview('filesDocumentKebijakan', 'previewDocumentKebijakan',
            'previewExistingDocumentKebijakan', 'countFilesDocumentKebijakan',
            'getFilesDocumentKebijakan');
        handleFilePreview('filesDocumentSasaran', 'previewDocumentSasaran', 'countFilesDocumentSasaran',
            'previewExistingDocumentSasaran',
            'getFilesDocumentSasaran');
        handleFilePreview('filesDocumentOrganisasi', 'previewDocumentOrganisasi',
            'previewExistingDocumentOrganisasi',
            'countFilesDocumentOrganisasi', 'getFilesDocumentOrganisasi');
    });
</script>
