@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <p class="title-body mb-1">Upload New Document</p>
                                </div>
                                <div class="card-body">
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
                                    <form action="{{ route('sop.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="tab-content mt-3" id="uploadTabContent">
                                            <!-- Data Document -->
                                            <div class="tab-pane fade show active" id="datadocs" role="tabpanel">
                                                <div class="card-body ml-2">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Document Category</label>
                                                                <select class="form-control" name="masterdocs"
                                                                    id="masterdocs" onchange="changeDocs(this)">
                                                                    <option value="" hidden>Category</option>
                                                                    @foreach ($masterdocs as $docs)
                                                                        <option value="{{ $docs->kode }}"
                                                                            {{ old('masterdocs') == $docs->kode ? 'selected' : '' }}>
                                                                            {{ $docs->name }}
                                                                        </option>
                                                                    @endforeach
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

                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg mt-3 position-relative">Submit</button>
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
                                            <!-- File Upload -->
                                            <div class="tab-pane fade" id="fileupload" role="tabpanel">
                                                <div class="row border-2">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Upload Multiple Files</label>
                                                            <input class="form-control" type="file" id="files"
                                                                name="file[]" multiple>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <img src="{{ asset('assets/img/icon/pdf.svg') }}"
                                                                alt="" style="width:40px; margin: 10px;">
                                                            <img src="{{ asset('assets/img/icon/xlsx.svg') }}"
                                                                alt="" style="width:40px; margin: 10px;">
                                                            <img src="{{ asset('assets/img/icon/docx.svg') }}"
                                                                alt="" style="width:40px; margin: 10px;">
                                                        </div>
                                                        <p style="color: rgb(25, 60, 218)">You can upload file pdf,
                                                            doc, docx,
                                                            xls, xlsx</p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Upload Multiple Files</label>
                                                    <input class="form-control" type="file" id="files2"
                                                        name="file2[]" multiple>
                                                </div>
                                            </div>
                                            <!-- Distribution -->
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
    });

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
