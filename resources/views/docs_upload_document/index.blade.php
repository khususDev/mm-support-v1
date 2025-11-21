@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl">
                            <div class="card mb-4">
                                <div class="row ml-3 mr-3 d-flex justify-content-between">
                                    <h2 class="title-body">
                                        Upload Document
                                    </h2>
                                </div>
                                <div class="card-body mt-4">
                                    <!-- TabNav -->
                                    <ul class="nav nav-tabs" id="uploadTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab"
                                                data-bs-target="#datadocs" type="button" role="tab">
                                                Data
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="template-tab" data-bs-toggle="tab"
                                                data-bs-target="#fileupload" type="button" role="tab">
                                                File
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="later-tab" data-bs-toggle="tab"
                                                data-bs-target="#distribusi" type="button" role="tab">
                                                Distribution
                                            </button>
                                        </li>
                                    </ul>
                                    <!-- EndTabNav -->

                                    <!-- Tab Content -->
                                    <form id="myForm" action="{{ route('uploaddocs.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @php
                                            $categoryMap = $categories->mapWithKeys(function ($cat) {
                                                return [
                                                    $cat->id => $cat->types->map(function ($t) {
                                                        return ['id' => $t->id, 'name' => $t->name];
                                                    }),
                                                ];
                                            });
                                        @endphp
                                        <div class="tab-content mt-3" id="uploadTabContent">
                                            <!-- Data Document -->
                                            <div class="tab-pane fade show active" id="datadocs" role="tabpanel">
                                                <div class="card-body ml-2">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Document Category</label>
                                                                <select class="form-control" name="category" id="category"
                                                                    onchange="changeCat(this)">
                                                                    <option value="" hidden>Select Category</option>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}"
                                                                            data-code="{{ $category->code }}">
                                                                            {{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Document Type</label>
                                                                <select class="form-control" name="masterdocs"
                                                                    id="masterdocs">
                                                                    <option value="" hidden>Select Type</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Department</label>
                                                                <select class="form-control" name="department"
                                                                    id="department" onchange="changeDept(this)">
                                                                    <option value="" hidden>Department</option>
                                                                    @foreach ($department as $dept)
                                                                        <option value="{{ $dept->code }}"
                                                                            {{ old('department') == $dept->code ? 'selected' : '' }}>
                                                                            {{ $dept->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: 3px">
                                                        <div class="form-group">
                                                            <label class="form-label">Document Number</label>
                                                            <input type="text" class="form-control" id="valuedocs"
                                                                aria-describedby="defaultFormControlHelp" name="valuedocs"
                                                                value="{{ old('valuedocs') }}"
                                                                style="width: 100px; font-size: 14px" readonly />
                                                            @error('name')
                                                                <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">s</label>
                                                            <input type="text" class="form-control" id="valuedocs2"
                                                                aria-describedby="defaultFormControlHelp" name="valuedocs2"
                                                                value="{{ old('valuedocs2') }}" style="font-size: 14px"
                                                                disabled />
                                                            @error('name')
                                                                <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Document Name</label>
                                                        <input type="text" class="form-control" id="namadocs"
                                                            aria-describedby="defaultFormControlHelp" name="namadocs"
                                                            value="{{ old('namadocs') }}" />
                                                        @error('name')
                                                            <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Document Description</label>
                                                        <textarea class="form-control" rows="5" name="deskripsi" id="deskripsi">{{ old('deskripsi') }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Effective Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_berlaku" name="tanggal_berlaku"
                                                                    value="{{ old('tanggal_berlaku') }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Validity Period (Year)</label>
                                                                <select class="form-control" id="jangka_waktu"
                                                                    name="jangka_waktu">
                                                                    <option value="" disabled selected>Select
                                                                    </option>
                                                                    <option value="1" @selected(old('jangka_waktu') == '1')>1
                                                                        Tahun
                                                                    </option>
                                                                    <option value="2" @selected(old('jangka_waktu') == '2')>2
                                                                        Tahun
                                                                    </option>
                                                                    <option value="3" @selected(old('jangka_waktu') == '3')>3
                                                                        Tahun
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Review Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_review" name="tanggal_review"
                                                                    value="{{ old('tanggal_review') }}" readonly />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Document Security</label>
                                                                <select class="form-control" id="security"
                                                                    name="security">
                                                                    <option value="" disabled selected>Select
                                                                    </option>
                                                                    <option value="Confidential"
                                                                        @selected(old('security') == 'Confidential')>
                                                                        Confidential
                                                                    </option>
                                                                    <option value="Internal" @selected(old('security') == 'Internal')>
                                                                        Internal
                                                                    </option>
                                                                    <option value="Restricted"
                                                                        @selected(old('security') == 'Restricted')>
                                                                        Restricted
                                                                    </option>
                                                                    <option value="Pulic" @selected(old('security') == 'Pulic')>
                                                                        Public
                                                                    </option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Authorization</label>
                                                                <select class="form-control" name="role"
                                                                    id="role">
                                                                    <option value="Tanpa-Approval" selected="selected">
                                                                        No Authorization Required</option>
                                                                    @foreach ($userapprove as $userapp)
                                                                        <option value="{{ $userapp->id }}">
                                                                            {{ $userapp->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--hide-->
                                                <div class="custom-input" hidden>
                                                    <p>No Dokumen :</p>
                                                    <div class="cst-field">
                                                        <input type="text" id="text1" class="text1"
                                                            name="text1" placeholder="_ _" required readonly>
                                                        <p>-</p>
                                                        <input type="text" id="text2" class="text2"
                                                            name="text2" placeholder="_ _" required readonly>
                                                        <p>_</p>
                                                        <input type="text" id="text3" class="text3"
                                                            name="text3" placeholder="_ _">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Document -->

                                            <!-- File Upload -->
                                            <div class="tab-pane fade" id="fileupload" role="tabpanel">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <img src="{{ asset('assets/img/icon/pdf.svg') }}" alt=""
                                                            style="width:40px; margin: 10px;">
                                                        <img src="{{ asset('assets/img/icon/xlsx.svg') }}" alt=""
                                                            style="width:40px; margin: 10px;">
                                                        <img src="{{ asset('assets/img/icon/docx.svg') }}" alt=""
                                                            style="width:40px; margin: 10px;">
                                                    </div>
                                                    <p style="color: rgb(25, 60, 218)">You can upload file pdf,
                                                        doc, docx,
                                                        xls, xlsx</p>
                                                </div>

                                                <div class="row">
                                                    {{-- Document Upload --}}
                                                    <div class="col-md-4">
                                                        <label class="form-label">Upload Multiple Document</label>
                                                        <div class="border rounded p-2">
                                                            <label
                                                                class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                                                                Choose Files
                                                                <input type="file" id="filesDocument" multiple hidden>
                                                            </label>
                                                            <span id="countFilesDocument"
                                                                class="text-muted small d-block text-center">0 files</span>
                                                            <div id="previewDocument" class="mt-2 small"></div>
                                                        </div>
                                                    </div>

                                                    {{-- Form Upload --}}
                                                    <div class="col-md-4">
                                                        <label class="form-label">Upload Multiple Form</label>
                                                        <div class="border rounded p-2">
                                                            <label
                                                                class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                                                                Choose Files
                                                                <input type="file" id="filesForm" multiple hidden>
                                                            </label>
                                                            <span id="countFilesForm"
                                                                class="text-muted small d-block text-center">0 files</span>
                                                            <div id="previewForm" class="mt-2 small"></div>
                                                        </div>
                                                    </div>

                                                    {{-- Diagram Upload --}}
                                                    <div class="col-md-4">
                                                        <label class="form-label">Upload Multiple Diagram</label>
                                                        <div class="border rounded p-2">
                                                            <label
                                                                class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                                                                Choose Files
                                                                <input type="file" id="filesDiagram" multiple hidden>
                                                            </label>
                                                            <span id="countFilesDiagram"
                                                                class="text-muted small d-block text-center">0 files</span>
                                                            <div id="previewDiagram" class="mt-2 small"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <!-- Document -->
                                                <div class="form-group">
                                                    <label class="form-label">Upload Multiple Document</label>
                                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                        <label class="btn btn-outline-primary btn-sm">
                                                            Choose Files
                                                            <input class="form-control" type="file" id="filesDocument"
                                                                multiple>
                                                        </label>
                                                    </div>
                                                    <div id="previewDocument" class="mt-2 file-preview-area"></div>
                                                </div>

                                                <!-- Form -->
                                                <div class="form-group">
                                                    <label class="form-label">Upload Multiple Form</label>
                                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                        <label class="btn btn-outline-primary btn-sm">
                                                            Choose Files
                                                            <input type="file" id="filesForm" multiple hidden>
                                                        </label>
                                                        <span id="countFilesForm" class="text-muted ml-2">0 files</span>
                                                    </div>
                                                    <div id="previewForm" class="mt-2"></div>
                                                </div>

                                                <!-- Diagram -->
                                                <div class="form-group">
                                                    <label class="form-label">Upload Multiple Diagram</label>
                                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                        <label class="btn btn-outline-primary btn-sm">
                                                            Choose Files
                                                            <input type="file" id="filesDiagram" multiple hidden>
                                                        </label>
                                                        <span id="countFilesDiagram" class="text-muted ml-2">0
                                                            files</span>
                                                    </div>
                                                    <div id="previewDiagram" class="mt-2"></div>
                                                </div> --}}
                                            </div>
                                            <!-- End File Upload -->

                                            <!-- Distribusi -->
                                            <div class="tab-pane fade" id="distribusi" role="tabpanel">
                                                <div class="form-group">
                                                    <div class="mb-2">
                                                        <input type="checkbox" id="selectAll" />
                                                        <label for="selectAll" style="font-weight: bold;">Pilih
                                                            Semua</label>
                                                    </div>
                                                    <div class="user-checkbox-list"
                                                        style="border: 1px solid #ced4da; border-radius: 5px; max-height: 200px; overflow-y: auto; padding: 10px;">
                                                        @foreach ($userd as $users)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="users[]" value="{{ $users->id }}"
                                                                    id="user{{ $users->id }}"
                                                                    {{ in_array($users->id, old('users', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="user{{ $users->id }}">
                                                                    {{ $users->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="d-flex mt-3">
                                                        <button class="btn btn-danger btn-lg back-tab"
                                                            data-prev="template-tab">Back</button>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-lg ml-2">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Distribusi -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

<style>
    .file-card {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .file-card:hover {
        transform: scale(1.01);
    }

    .file-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 15px;
    }

    .file-info {
        flex: 1;
        overflow: hidden;
    }

    .file-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-remove {
        margin-left: 10px;
    }

    .file-preview-text-container {
        flex: 1;
        max-width: 400px;
        /* Bisa diatur sesuai kebutuhan */
        overflow: hidden;
    }

    .file-preview-text {
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
    }

    .user-checkbox-list {
        font-size: 14px;
        background-color: #f8f9fa;
    }

    .form-check {
        margin-bottom: 8px;
    }

    .form-check-input {
        margin-right: 10px;
    }

    .nav-tabs .nav-link {
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        transition: all 0.3s ease-in-out;
        font-family: 'Courier New', Courier, monospace;
    }

    .nav-tabs .nav-link.active {
        background: #007bff;
        color: #6c757d;
    }

    .tab-content {
        animation: fadeEffect 0.5s ease;
    }

    @keyframes fadeEffect {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<link rel="stylesheet" href="{{ asset('assets/css/master.css') }}">
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {

        const categoryToTypes = @json($categoryMap);

        const categorySelect = document.getElementById('category');
        const typeSelect = document.getElementById('masterdocs');

        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            typeSelect.innerHTML = '<option value="">-- Select Type --</option>';

            if (categoryToTypes[categoryId]) {
                categoryToTypes[categoryId].forEach(function(type) {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.text = type.name;
                    typeSelect.appendChild(option);
                });
            }
        });

        document.querySelectorAll(".back-tab").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah reload

                let prevTab = this.getAttribute("data-prev");
                let prevTabButton = document.querySelector(`#${prevTab}`);
                if (prevTabButton) {
                    prevTabButton.click();
                }
            });
        });

        let tanggalBerlakuInput = document.getElementById("tanggal_berlaku");
        let jangkaWaktuSelect = document.getElementById("jangka_waktu");
        let tanggalReviewInput = document.getElementById("tanggal_review");

        function hitungTanggalReview() {
            let tanggalBerlaku = tanggalBerlakuInput.value;
            let tahunTambahan = parseInt(jangkaWaktuSelect.value);

            if (tanggalBerlaku && tahunTambahan) {
                let tanggal = new Date(tanggalBerlaku);
                tanggal.setFullYear(tanggal.getFullYear() + tahunTambahan); // Tambahkan tahun

                let tahun = tanggal.getFullYear();
                let bulan = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                let hari = tanggal.getDate().toString().padStart(2, '0');

                tanggalReviewInput.value = `${tahun}-${bulan}-${hari}`;
            } else {
                tanggalReviewInput.value = "";
            }
        }

        tanggalBerlakuInput.addEventListener("change", hitungTanggalReview);
        jangkaWaktuSelect.addEventListener("change", hitungTanggalReview);

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
                            `<img src="${iconPath}" class="rounded" style="width: 30px; height: 30px; object-fit: contain;">`;
                    }

                    const item = document.createElement("div");
                    item.className =
                        "d-flex align-items-center justify-content-between mb-1 bg-light rounded px-2 py-1";
                    item.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        ${icon}
                        <div class="small">${file.name}</div>
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

            // Global untuk dipanggil saat submit
            window[fileArrayName] = () => selectedFiles;
        }

        // Inisialisasi untuk setiap kelompok file
        handleFilePreview('filesDocument', 'previewDocument', 'countFilesDocument', 'getFilesDocument');
        handleFilePreview('filesForm', 'previewForm', 'countFilesForm', 'getFilesForm');
        handleFilePreview('filesDiagram', 'previewDiagram', 'countFilesDiagram', 'getFilesDiagram');

        // Proses submit form dengan membawa file dari semua grup
        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Gabungkan file dari masing-masing array global
            getFilesDocument().forEach(file => {
                formData.append('file[]', file);
            });
            getFilesForm().forEach(file => {
                formData.append('file2[]', file);
            });
            getFilesDiagram().forEach(file => {
                formData.append('file3[]', file);
            });

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Upload gagal');
                    return response.text();
                })
                .then(result => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Dokumen berhasil diupload!',
                        text: 'Terima kasih telah mengunggah dokumen.',
                        color: '#000',
                        iconColor: '#198754',
                        confirmButtonColor: '#198754',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // ⏳ Redirect setelah delay biar user lihat alert-nya dulu
                    setTimeout(() => {
                        window.location.href = "{{ route('uploaddocs.index') }}";
                    }, 1500);
                })
                .catch(error => {
                    alert('Upload gagal: ' + error.message);
                });
        });
    });

    function changeCat(selectValue) {
        var selectedOption = selectValue.options[selectValue.selectedIndex];
        var categoryCode = selectedOption.dataset.code;
        console.log(categoryCode);

        document.getElementById("text1").value = categoryCode;
        getiddok();
    }

    $(".next-tab").on("click", function() {
        var nextTab = $(this).data("next"); // Ambil tab berikutnya
        $("#" + nextTab).trigger("click"); // Klik tab berikutnya
    });


    function changeDept(selectValue) {
        var x = selectValue.value;
        console.log(x);
        document.getElementById("text2").value = x;
        getiddok();
        if (x !== "") {
            $('#valuedocs2').prop('disabled', false);
        } else {
            $('#valuedocs2').prop('disabled', true);
        }
    }

    function getiddok() {
        var input1 = document.getElementById('text1');
        var input2 = document.getElementById('text2');
        var inputValue = input1.value + '-' + input2.value + '-';
        console.log(inputValue);
        document.getElementById("valuedocs").value = inputValue;

    }

    document.addEventListener('DOMContentLoaded', (event) => {
        console.log("DOM dijalankan");
        var selectAllCheckbox = document.getElementById('selectAll');

        if (selectAllCheckbox) {
            console.log('Select All checkbox state changed: ' + this.checked);
            selectAllCheckbox.addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('input[name="users[]"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                    console.log('Checkbox Value:' + checkbox.value +
                        'Checkbox state changed: ' + checkbox.checked);
                }, this);
            });
        } else {
            console.error('Element with ID "selectAll" not found');
        }
    });
</script>
