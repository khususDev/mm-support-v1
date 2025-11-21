@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl">
                            <div class="card mb-2">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <p class="title-body mb-1">Detail Document</p>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
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

                                        <!-- Toggle Switch -->
                                        <div>
                                            <p style="margin: 0; align-items: ">Edit</p>
                                            @if ($userx == 'Admin')
                                                <label class="switch">Edit
                                                    <input type="checkbox" id="toggleSwitch">
                                                    <span class="slider round"></span>
                                                </label>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Tab Content -->
                                    <form action="{{ route('official.store') }}" method="POST"
                                        enctype="multipart/form-data" id="formData">
                                        @csrf
                                        <div class="tab-content mt-2" id="uploadTabContent">
                                            <!-- Data Document -->
                                            <div class="tab-pane fade show active" id="datadocs" role="tabpanel">
                                                <div class="card-body">
                                                    <div class="row" style="margin-left: 3px">
                                                        <div class="form-group">
                                                            <label class="form-label">Document Number</label>
                                                            <input type="text" class="form-control force-disabled"
                                                                id="nodocs" aria-describedby="defaultFormControlHelp"
                                                                name="nodocs"
                                                                value="{{ old('namadocument', $docs->nodocument ?? '') }}"
                                                                disabled />
                                                            @error('name')
                                                                <small>{{ $message }}</small>
                                                            @enderror
                                                            @error('name')
                                                                <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Document Category</label>
                                                                <select class="form-control editable" name="masterdocs"
                                                                    id="masterdocs" onchange="changeDocs(this)" disabled>
                                                                    <option value="" hidden>Category</option>
                                                                    @foreach ($masterdocs as $master)
                                                                        <option value="{{ $master->id }}"
                                                                            {{ isset($docs) && $docs->jenis_document_id == $master->id ? 'selected' : '' }}>
                                                                            {{ $master->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Department</label>
                                                                <select class="form-control editable" name="department"
                                                                    id="department" onchange="changeDept(this)">
                                                                    <option value="" hidden>Department</option>
                                                                    @foreach ($department as $dept)
                                                                        <option value="{{ $dept->id }}"
                                                                            {{ isset($docs) && $docs->department_id == $dept->id ? 'selected' : '' }}>
                                                                            {{ $dept->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Document Name</label>
                                                        <input type="text" class="form-control editable" id="namadocs"
                                                            aria-describedby="defaultFormControlHelp" name="namadocs"
                                                            value="{{ old('namadocument', $docs->namadocument ?? '') }}"
                                                            disabled />
                                                        @error('name')
                                                            <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Document Description</label>
                                                        <textarea class="form-control editable" rows="5" name="deskripsi" id="deskripsi" disabled>
                                                            {{ old('deskripsi', $docs->deskripsi ?? '') }}
                                                        </textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Effective Date</label>
                                                                <input type="date" class="form-control editable"
                                                                    id="tanggal_berlaku" name="tanggal_berlaku"
                                                                    value="{{ old('tanggal_berlaku', $docs->tanggal_berlaku ?? '') }}"
                                                                    disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Validity Period (Year)</label>
                                                                <select class="form-control editable" id="jangka_waktu"
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
                                                                <input type="date" class="form-control force-disabled"
                                                                    id="tanggal_review" name="tanggal_review"
                                                                    value="{{ old('tanggal_review', $docs->tanggal_review ?? '') }}"
                                                                    disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Document Security</label>
                                                                <select class="form-control editable" id="security"
                                                                    name="security" disabled>
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
                                                                <select class="form-control editable" name="role"
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
                                            <div class="tab-pane fade" id="fileupload" role="tabpanel">
                                                <div class="form-group">
                                                    <!-- File Upload -->
                                                    <div class="card p-3 border mt-3" id="fileupload">
                                                        <label class="form-label px-2"
                                                            style="position: absolute; top: -15px; left: 10px; background: white; padding: 0 3px; font-size:18px; color:#333334">Documents</label>

                                                        <div class="row">
                                                            @foreach ($path_document as $docs)
                                                                @php
                                                                    $extension = strtolower(
                                                                        pathinfo($docs->path, PATHINFO_EXTENSION),
                                                                    );
                                                                    $allowedExtensions = [
                                                                        'pdf',
                                                                        'xlsx',
                                                                        'xls',
                                                                        'docx',
                                                                        'doc',
                                                                    ];
                                                                    $iconPath = asset('assets/img/icon/default.svg');

                                                                    if (in_array($extension, $allowedExtensions)) {
                                                                        $iconPath = asset(
                                                                            "assets/img/icon/$extension.svg",
                                                                        );
                                                                    }
                                                                @endphp

                                                                @if (in_array($extension, $allowedExtensions))
                                                                    <div class="col-md-1 text-center">
                                                                        <div class="card p-2 border">
                                                                            <img src="{{ $iconPath }}"
                                                                                alt="{{ $extension }}" class="mx-auto"
                                                                                style="width: 50px">
                                                                            <a href="{{ route('previewFile', ['folder' => 'forms', 'filename' => basename($docs->path)]) }}"
                                                                                target="_blank">
                                                                                {{ basename($docs->name) }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="card pt-3 border mt-3">
                                                        <label class="form-label px-2"
                                                            style="position: absolute; top: -15px; left: 10px; background: white; padding: 0 3px; font-size:18px; color:#333334">Form</label>

                                                        <div class="row">
                                                            @foreach ($path_form as $docs)
                                                                @php
                                                                    $extension = strtolower(
                                                                        pathinfo($docs->path, PATHINFO_EXTENSION),
                                                                    );
                                                                    $allowedExtensions = [
                                                                        'pdf',
                                                                        'xlsx',
                                                                        'xls',
                                                                        'docx',
                                                                        'doc',
                                                                    ];
                                                                    $iconPath = asset('assets/img/icon/default.svg');

                                                                    if (in_array($extension, $allowedExtensions)) {
                                                                        $iconPath = asset(
                                                                            "assets/img/icon/$extension.svg",
                                                                        );
                                                                    }
                                                                @endphp

                                                                @if (in_array($extension, $allowedExtensions))
                                                                    <div class="col-md-1 text-center">
                                                                        <div class="card p-2 border">
                                                                            <img src="{{ $iconPath }}"
                                                                                alt="{{ $extension }}" class="mx-auto"
                                                                                style="width: 50px">
                                                                            <a href="{{ route('previewFile', ['folder' => 'forms', 'filename' => basename($docs->path)]) }}"
                                                                                target="_blank">
                                                                                {{ basename($docs->name) }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Distribution -->
                                            <div class="tab-pane fade" id="distribusi" role="tabpanel">
                                                <div class="form-group">
                                                    <div class="mb-2">
                                                        <input type="checkbox" id="selectAll" class="editable"
                                                            disabled />
                                                        <label for="selectAll">Pilih
                                                            Semua</label>
                                                    </div>
                                                    <div class="user-checkbox-list"
                                                        style="border: 1px solid #ced4da; border-radius: 5px; max-height: 200px; overflow-y: auto; padding: 10px;">
                                                        @foreach ($userd as $users)
                                                            <div class="form-check">
                                                                <input class="form-check-input editable" type="checkbox"
                                                                    name="users[]" value="{{ $users->id }}"
                                                                    id="user{{ $users->id }}"
                                                                    {{ in_array($users->id, $distribusi) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="user{{ $users->id }}">
                                                                    {{ $users->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
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
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 25px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 17px;
        width: 17px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
    }


    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
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
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        transition: all 0.3s ease-in-out;
        font-family: 'Courier New', Courier, monospace;
    }

    .nav-tabs .nav-link.active {
        background: #007bff;
        color: #6c757d;
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

        const toggleSwitch = document.getElementById("toggleSwitch");
        const formElements = document.querySelectorAll("#formData input, #formData select, #formData textarea");

        function toggleEdit(enable) {
            formElements.forEach(el => {
                // Cek apakah input ini seharusnya tetap disable
                if (!el.classList.contains("force-disabled")) {
                    el.disabled = !enable;
                    el.classList.toggle("editable", !enable); // Hapus CSS biar kelihatan aktif
                }
            });
        }
        console.log("DISABLE INPUT DI AWAL...");
        toggleEdit(false); // **HARUS Disable di awal**


        toggleSwitch.addEventListener("change", function() {
            console.log("Toggle diklik, kondisi sekarang:", this.checked);
            toggleEdit(this.checked);
        });

    });

    function toggleEdit(enable = false) {
        let inputs = document.querySelectorAll(".editable");

        inputs.forEach(input => {
            input.disabled = !enable;
        });
    }


    function changeDocs(selectValue) {
        var x = selectValue.value;
        console.log(x);

        document.getElementById("text1").value = x;
        getiddok();
    }

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
