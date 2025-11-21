@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-3">
                    <div class="row ml-3 mr-3 d-flex justify-content-between align-items-center">
                        {{-- <button class="btn btn-danger">X</button> --}}
                        <h2 class="title-body">
                            Upload Prosedur Mutu
                        </h2>
                    </div>
                </div>
                <div class="card mt-3">
                    <!-- Tab Headers -->
                    <div class="tabs justify-content-between m-1">
                        <button class="tab-item active ml-4" onclick="showTab('data')">
                            <p id="text-tab">Data</p>
                        </button>
                        <button class="tab-item" onclick="showTab('files')">
                            <p id="text-tab">Files</p>
                        </button>
                        <button class="tab-item mr-4" onclick="showTab('distribusi')">
                            <p id="text-tab">Distribusi</p>
                        </button>

                        <style>
                            #text-tab {
                                font-family: monospace;
                                font-size: large;
                                font-weight: bold;
                            }
                        </style>
                    </div>

                    <!-- EndTabNav -->

                    <!-- Tab Content -->
                    <form id="myForm" action="{{ route('docs_qualityprocedure.store') }}" method="POST"
                        enctype="multipart/form-data" id="formData">
                        @csrf
                        <div class="tab-container">
                            <!-- Data -->
                            @include('docs_quality_procedure.tab_data')
                            <!-- End Data -->

                            <!-- File Upload -->
                            @include('docs_quality_procedure.tab_files')
                            <!-- End File Upload -->

                            <!-- Distribusi -->
                            @include('docs_quality_procedure.tab_distribusi')
                            <!-- End Distribusi -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .tabs {
        display: flex;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 20px;
    }

    .tab-container {
        height: 100vh;
    }

    .card-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .tab-item {
        padding: 10px 20px;
        cursor: pointer;
        color: #444;
        border: none;
        background: transparent;
        font-weight: 500;
        position: relative;
        transition: 0.3s;
        flex: 1;
    }

    .tab-item:focus {
        outline: none !important;
        box-shadow: none #007bff;
    }

    .tab-item.active {
        color: #007bff;
        background-color: #eaeefa;
    }

    .tab-item.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        height: 2px;
        width: 100%;
        background-color: #007bff;
        border-radius: 2px;
    }

    .tab-content-custom {
        display: none;
    }

    .tab-content-custom.active {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .text-danger {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script type="text/javascript">
    function changeDocs(selectValue) {
        var selectedOption = selectValue.value;
        console.log(selectedOption);

        document.getElementById("text1").value = selectedOption;
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

    document.addEventListener("DOMContentLoaded", function() {
        // Navigasi Tab
        const tabContents = document.querySelectorAll('.tab-content-custom');

        // Fungsi untuk mengubah tab
        function switchTab(targetTabId) {
            tabContents.forEach(tab => {
                tab.classList.remove('active');
                if (tab.id === targetTabId) {
                    tab.classList.add('active');
                }
            });

            const tabButtons = document.querySelectorAll('.tab-item');
            tabButtons.forEach(button => {
                button.classList.remove('active');
                if (button.getAttribute('onclick')?.includes(`'${targetTabId}'`)) {
                    button.classList.add('active');
                }
            });

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Fungsi validasi form
        function validateCurrentTab() {
            let isValid = true;

            // Daftar field yang wajib diisi
            const requiredFields = [{
                    id: 'masterdocs',
                    message: 'Jenis Dokumen harus dipilih'
                },
                {
                    id: 'department',
                    message: 'Department harus dipilih'
                },
                {
                    id: 'namadocs',
                    message: 'Document Name harus diisi'
                },
                {
                    id: 'deskripsi',
                    message: 'Document Description harus diisi'
                },
                {
                    id: 'tanggal_berlaku',
                    message: 'Effective Date harus diisi'
                },
                {
                    id: 'jangka_waktu',
                    message: 'Validity Period harus dipilih'
                },
                {
                    id: 'security',
                    message: 'Document Security harus dipilih'
                },
                {
                    id: 'valuedocs2',
                    message: 'Number Document harus diisi'
                }
            ];

            // Reset semua error terlebih dahulu
            requiredFields.forEach(fieldInfo => {
                const field = document.getElementById(fieldInfo.id);
                field.classList.remove('is-invalid');
                if (field.nextElementSibling && field.nextElementSibling.classList.contains(
                        'error-message')) {
                    field.nextElementSibling.remove();
                }
            });

            // Validasi setiap field
            requiredFields.forEach(fieldInfo => {
                const field = document.getElementById(fieldInfo.id);

                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');

                    // Tambahkan pesan error jika belum ada
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains(
                            'error-message')) {
                        const error = document.createElement('small');
                        error.classList.add('text-danger', 'error-message');
                        error.textContent = fieldInfo.message;
                        field.parentNode.appendChild(error);
                    }

                    // Scroll ke field pertama yang error
                    if (isValid === false) { // hanya scroll ke yang pertama
                        field.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        isValid = false; // tetap false untuk field berikutnya
                    }
                }
            });

            return isValid;
        }

        // Handle tombol next dengan validasi ketat
        document.querySelectorAll('.next-tab').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (validateCurrentTab()) {
                    const targetTab = this.getAttribute('data-target');
                    switchTab(targetTab);
                } else {
                    // Tampilkan alert jika ingin (optional)
                    alert('Harap lengkapi semua data yang dibutuhkan sebelum melanjutkan');
                }
            });
        });

        // Handle tombol back (tanpa validasi)
        document.querySelectorAll('.prev-tab').forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-target');
                switchTab(targetTab);
            });
        });

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

        const typeSelect = document.getElementById('masterdocs');

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

        function handleFilePreview(inputId, previewId, countId, fileArrayName) {
            let selectedFiles = [];

            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const count = document.getElementById(countId);

            // Tambahkan style untuk container preview
            preview.style.maxHeight = '350px'; // Atur tinggi maksimal sesuai kebutuhan
            preview.style.overflowY = 'auto'; // Aktifkan scroll vertikal
            preview.style.overflowX = 'hidden'; // Pastikan tidak ada scroll horizontal

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
                formData.append('documents[]', file);
            });
            getFilesForm().forEach(file => {
                formData.append('forms[]', file);
            });
            getFilesDiagram().forEach(file => {
                formData.append('diagrams[]', file);
            });

            // Tampilkan loading indicator
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
            submitButton.disabled = true;

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const contentType = response.headers.get('content-type');

                    if (!response.ok) {
                        let errorMessage = 'Terjadi kesalahan saat menyimpan data.';

                        if (contentType && contentType.includes('application/json')) {
                            const errorData = await response.json();

                            // Format pesan error dari Laravel validation
                            if (errorData.errors) {
                                errorMessage = Object.values(errorData.errors)
                                    .flat()
                                    .join('<br>');
                            } else if (errorData.message) {
                                errorMessage = errorData.message;
                            }
                        } else {
                            errorMessage = await response.text();
                        }

                        throw new Error(errorMessage);
                    }

                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: result.message || 'Dokumen berhasil diupload!',
                            color: '#000',
                            iconColor: '#198754',
                            confirmButtonColor: '#198754',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        setTimeout(() => {
                            window.location.href =
                                "{{ route('docs_qualityprocedure.index') }}";
                        }, 1500);
                    } else {
                        throw new Error(result.message || 'Ada kesalahan pada data yang dikirim.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: `<div style="text-align:left; max-height:300px; overflow-y:auto;">
                     <strong>Detail Error:</strong><br>
                     ${error.message || 'Tidak ada detail error yang tersedia.'}
                   </div>`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#dc3545',
                        scrollbarPadding: false
                    });
                })
                .finally(() => {
                    // Kembalikan tombol ke state semula
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
        });


    });
</script>
