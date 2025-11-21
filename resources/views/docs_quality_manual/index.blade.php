@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-3">
                    <div class="row ml-3 mr-3 d-flex justify-content-between">
                        <div class="titles d-flex justify-content-center">
                            <i class="fas fa-landmark mt-2" style="color: #020d71; font-size: 20px;"></i>
                            <h2 class="title-body ml-3 mt-1">
                                Manual Mutu
                            </h2>
                        </div>
                        <div class="action">
                            <a href="{{ route('docs_qualitymanual.edit', Crypt::encryptString($nodocs)) }}"
                                class="btn btn-secondary ml-2" id="btn-create" style="color: #333"><i
                                    class="fas fa-plus-square"></i> Update Document</a>
                        </div>
                    </div>
                </div>

                {{-- Card: Overview --}}
                <div class="card ml-4 mr-4 mb-4 shadow">
                    <div class="title">
                        <p>Document Overview</p>
                    </div>
                    <div class="card-body">

                        <div class="d-flex">
                            <div class="no-dokumen">
                                <label class="form-label small">No Dokumen</label>
                                <h6 class="no-docs">{{ $document->no_document }}</h6>
                            </div>

                            <div class="no-revisi" style="margin-left: 15rem">
                                <label class="form-label small">Revisi</label>
                                <h6 class="no-revisi">{{ $document->revisi }}</h6>
                            </div>
                        </div>

                        <div class="nama-dokumen mt-3">
                            <label class="form-label small">Jenis Dokumen</label>
                            <h6 class="nama-docs">{{ $document->nama_document }}</h6>
                        </div>

                        <div class="desc mt-4">
                            <label for="" class="form-label small">Perusahaan</label>
                            <h5 class="perusahaan" style="font-weight:bold">{{ $document->perusahaan }}</h5>
                        </div>

                        <div class="desc mt-4">
                            <label for="" class="form-label small">Alamat</label>
                            <p class="text-muted">{{ $document->alamat }}</p>
                        </div>

                        <div class="jenis-dok" style="width: 50%">
                            <label for="" class="form-label small">Tanggal Berlaku</label>
                            <p class="text-muted">
                                {{ \Carbon\Carbon::parse($document->tanggal)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div class="col-10 d-flex p-0 mt-3">
                            <div class="status mt-3">
                                <label class="form-label small">Dibuat oleh</label>
                                <div><span class="badge bg-info" style="color: #ffffff">{{ $document->uname1 }}</span>
                                </div>
                            </div>

                            <div class="divider"></div>
                            <div class="status mt-3">
                                <label class="form-label small">Diperiksa oleh</label>
                                <div><span class="badge bg-warning" style="color: #ffffff">{{ $document->uname2 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex p-0 mt-3">
                            <div class="status">
                                <label class="form-label small mb-3">Status Dokumen</label>
                                <div>
                                    @if ($statusdocument == '2')
                                        <span class="badge bg-info" style="color: #fff">Approved</span>
                                    @elseif($statusdocument == '1')
                                        <span class="badge bg-warning" style="color: #ffffff"><i
                                                class="fas fa-clock mr-1"></i>
                                            Waiting Approval</span>
                                    @elseif($statusdocument == '3')
                                        <span class="badge bg-success" style="color: #fff">Published</span>
                                    @elseif($statusdocument == '4')
                                        <span class="badge bg-danger" style="color: #fff">Obsolete</span>
                                    @elseif($statusdocument == '5')
                                        <span class="badge bg-danger" style="color: #fff">Archived</span>
                                    @else
                                        <span class="badge bg-secondary"
                                            style="color: #fff">{{ $document->statusdocument }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="divider"></div>

                            <div class="status">
                                <label class="form-label small">Disetujui oleh</label>
                                <div>
                                    @if ($approvals->isEmpty())
                                        <span style="color: #080808; font-weight:bold;">Unassigned</span>
                                    @else
                                        <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                                            @foreach ($approvals as $approval)
                                                <div class="d-flex align-items-center">
                                                    @if ($approval->avatar)
                                                        <img src="{{ asset('assets/img/avatar/' . $approval->avatar) }}"
                                                            class="rounded-circle me-2" width="36" height="36"
                                                            alt="{{ $approval->name }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.svg') }}'">
                                                    @else
                                                        @php
                                                            $nameParts = explode(' ', $approval->name);
                                                            $initials = '';
                                                            foreach ($nameParts as $part) {
                                                                $initials .= strtoupper(substr($part, 0, 1));
                                                            }
                                                            $colors = [
                                                                'bg-primary',
                                                                'bg-success',
                                                                'bg-danger',
                                                                'bg-warning',
                                                                'bg-info',
                                                            ];
                                                            $randomColor = $colors[array_rand($colors)];
                                                        @endphp
                                                        <div class="rounded-circle {{ $randomColor }} text-white d-flex align-items-center justify-content-center"
                                                            style="width: 36px; height: 36px; font-size: 0.8rem;">
                                                            {{ $initials }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        style="color: #040404; margin-left: 5px;">{{ $approval->name }}</span>
                                                </div>
                                                @if (!$loop->last)
                                                    <div class="divider2"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Distribusi --}}
                <div class="card ml-4 mr-4 mb-4 shadow">
                    <div class="title">
                        <p>Document Distribusikan</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($distribusi as $userId => $userData)
                                @php
                                    $user = is_array($userData) ? $userData : ['name' => $userData, 'avatar' => null];
                                    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
                                    $randomColor = $colors[array_rand($colors)];
                                    $initials = implode(
                                        '',
                                        array_map(function ($n) {
                                            return strtoupper($n[0]);
                                        }, explode(' ', $user['name'])),
                                    );
                                @endphp

                                <div class="d-flex align-items-center">
                                    @if ($user['avatar'])
                                        <img src="{{ asset('assets/img/avatar/' . $user['avatar']) }}"
                                            class="rounded-circle me-2" width="36" height="36"
                                            alt="{{ $user['name'] }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.svg') }}'">
                                    @else
                                        <div class="rounded-circle {{ $randomColor }} text-white d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px; font-size: 0.8rem;">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    <span class="ms-2 ml-2">{{ $user['name'] }}</span>
                                </div>
                                <div class="divider"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Card: Document Files --}}
                <div class="card ml-4 mr-4 mb-4 shadow">
                    <div class="title">
                        <p>Document File</p>
                    </div>
                    <div class="card-body">
                        {{-- Tab Header --}}
                        <ul class="nav nav-tabs mb-3" id="customFieldTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="kebijakan-tab" data-bs-toggle="tab"
                                    data-bs-target="#kebijakan" type="button" role="tab">Kebijakan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sasaran-tab" data-bs-toggle="tab" data-bs-target="#sasaran"
                                    type="button" role="tab">Sasaran</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="organisasi-tab" data-bs-toggle="tab"
                                    data-bs-target="#organisasi" type="button" role="tab">Organisasi</button>
                            </li>
                            <!-- Tambah tab lainnya sesuai kebutuhan -->
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content">
                            @include('docs_quality_manual.tab_index.kebijakan')
                            @include('docs_quality_manual.tab_index.sasaran')
                            @include('docs_quality_manual.tab_index.organisasi')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

<style>
    p .title-detail {
        color: #0056b3;
        font-size: clamp(1.2rem, 2vw, 1.5rem);
        font-weight: 600;
        letter-spacing: 1.5px;
    }

    #icon {
        color: #0056b3;
    }

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

    .delete-form {
        position: absolute;
        top: 8px;
        right: 8px;
    }



    .delete-btn {
        background-color: transparent;
        border: none;
        color: #dc3545;
        /* Ukuran icon lebih besar */
        cursor: pointer;
        padding: 6px;
        line-height: 1;
    }

    .delete-btn .icon-delete {
        font-size: 16px;
        color: red;
    }

    .preview-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        width: 100px;
        margin: 10px;
        position: relative;
    }

    .preview-item canvas,
    .preview-item img {
        max-width: 100%;
        max-height: 60px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    .preview-item .file-name {
        font-size: 12px;
        text-align: center;
        margin-top: 5px;
        word-break: break-word;
        max-width: 100%;
    }

    #countFilesDocumentKebijakan {
        font-size: 13px;
        margin-top: -6px;
    }

    .divider {
        border-left: 1px solid #ccc;
        height: 30px;
        margin: 25px;
    }

    .divider2 {
        border-left: 1px solid #ccc;
        height: 15px;
        margin: 10px 20px;
    }

    #icon {
        font-size: 30px;
    }

    .title {
        border: none;
        border-bottom: 1px solid #e0e6ed;
        height: 7vh;
        padding: 5px;
        color: rgb(109, 109, 118);
    }

    .title p {
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-size: 14px;
        font-weight: bold;
        margin-left: 10px;
    }

    .card_container {
        height: 100%;
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e0e6ed;
        background-color: #fff !important;
    }

    .header {
        border: none;
        border-bottom: 1px solid #e0e6ed;
        height: 10vh;
        padding: 20px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM dijalankan");

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

        function handleFileUpload(event, jenis) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('jenis', jenis);
            formData.append('no_document', '{{ $nodocs }}');

            fetch("{{ route('docs_qualitymanual.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Atau append ke DOM manual
                    } else {
                        alert('Gagal upload file');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                });
        }

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
                    const ext = file.name.split('.').pop().toLowerCase();

                    const item = document.createElement("div");
                    item.className = "position-relative d-inline-block m-2 text-center";
                    item.style.width = "200px";
                    item.style.fontSize = "16px";

                    const iconWrapperContainer = document.createElement("div");
                    iconWrapperContainer.className = "bg-light rounded p-2";

                    let iconWrapper;

                    if (fileType.startsWith("image/")) {
                        iconWrapper = document.createElement("img");
                        iconWrapper.src = URL.createObjectURL(file);
                        iconWrapper.style.width = "160px";
                        iconWrapper.style.height = "200px";
                        iconWrapper.style.objectFit = "cover";
                        iconWrapper.classList.add("rounded");
                    } else if (ext === 'pdf') {
                        iconWrapper = document.createElement("canvas");
                        iconWrapper.width = 60;
                        iconWrapper.height = 80;

                        const fileReader = new FileReader();
                        fileReader.onload = function() {
                            const typedarray = new Uint8Array(this.result);
                            pdfjsLib.getDocument(typedarray).promise.then(pdf => {
                                pdf.getPage(1).then(page => {
                                    const scale = 0.2;
                                    const viewport = page.getViewport({
                                        scale: scale
                                    });
                                    const context = iconWrapper.getContext("2d");
                                    iconWrapper.height = viewport.height;
                                    iconWrapper.width = viewport.width;
                                    page.render({
                                        canvasContext: context,
                                        viewport: viewport
                                    });
                                });
                            });
                        };
                        fileReader.readAsArrayBuffer(file);
                    } else {
                        iconWrapper = document.createElement("img");
                        let iconPath = '';
                        switch (ext) {
                            case 'doc':
                            case 'docx':
                                iconPath = "{{ asset('assets/img/icon/docx.svg') }}";
                                break;
                            case 'xls':
                            case 'xlsx':
                                iconPath = "{{ asset('assets/img/icon/xlsx.svg') }}";
                                break;
                            default:
                                iconPath = "{{ asset('assets/img/icon/file.svg') }}";
                        }
                        iconWrapper.src = iconPath;
                        iconWrapper.style.width = "60px";
                        iconWrapper.style.height = "180px";
                        iconWrapper.style.objectFit = "contain";
                    }

                    iconWrapperContainer.appendChild(iconWrapper);
                    item.appendChild(iconWrapperContainer);

                    // Nama file
                    const fileName = document.createElement("div");
                    fileName.className = "small mt-1 text-truncate";
                    fileName.textContent = file.name;
                    item.appendChild(fileName);

                    // Tombol hapus (pojok kanan atas)
                    const removeBtn = document.createElement("button");
                    removeBtn.type = "button";
                    removeBtn.className = "btn btn-sm btn-danger position-absolute";
                    removeBtn.style.top = "4px";
                    removeBtn.style.right = "4px";
                    removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    // removeBtn.setAttribute("data-index", index);
                    removeBtn.style.borderRadius = "50%";
                    removeBtn.style.padding = "6px 8px";

                    item.appendChild(removeBtn);
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
        handleFilePreview('filesDocumentKebijakan', 'previewDocumentKebijakan', 'countFilesDocumentKebijakan',
            'getFilesDocumentKebijakan');
        handleFilePreview('filesDocumentSasaran', 'previewDocumentSasaran', 'countFilesDocumentSasaran',
            'getFilesDocumentSasaran');
        handleFilePreview('filesDocumentOrganisasi', 'previewDocumentOrganisasi',
            'countFilesDocumentOrganisasi', 'getFilesDocumentOrganisasi');
    });
</script>
