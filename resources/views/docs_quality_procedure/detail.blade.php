@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card_container">
                {{-- Card Header --}}
                <div class="header d-flex align-items-center mb-3">
                    <!-- Back Button (Left) -->
                    <a href="{{ route('docs_qualityprocedure.index') }}" class="btn btn-light rounded shadow"
                        style="background-color: #ffffff">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>

                    <!-- Document Title (Center) - flex-grow will push it to center -->
                    <div class="flex-grow-1 text-center">
                        <p class="ml-2 title-detail"
                            style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                            Detail Prosedur Mutu
                        </p>
                    </div>

                    <!-- Update Button (Right) - Only for Admin -->
                    @if ($userx == 'Admin')
                        <a href="#" class="btn btn-light rounded shadow" style="background-color: #ffffff">
                            <i class="fas fa-pen mr-1"></i> Update
                        </a>
                    @else
                        <!-- Empty div to maintain space when button is hidden -->
                        <div style="width: 68px;"></div> <!-- Adjust width to match your button size -->
                    @endif
                </div>

                {{-- Card: Overview --}}
                <div class="card m-4 shadow">
                    <div class="title">
                        <p>Document Overview</p>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <div class="no-dokumen">
                                <label class="form-label small">No Dokumen</label>
                                <h6 class="no-docs">{{ $document->nodocument }}</h6>
                            </div>

                            <div class="no-revisi">
                                <label class="form-label small">Revisi</label>
                                <h6 class="no-revisi">{{ $document->revisidocument }}</h6>
                            </div>
                        </div>

                        <div class="nama-dokumen mt-3">
                            <label class="form-label small">Nama Dokumen</label>
                            <h6 class="nama-docs">{{ $document->namadocument }}</h6>
                        </div>

                        <div class="desc mt-4">
                            <label for="" class="form-label small">Deskripsi</label>
                            <p class="text-muted">{{ $document->deskripsi }}</p>
                        </div>

                        <div class="col-10 d-flex p-0 mt-4 justify-content-between">
                            <div class="jenis-dok" style="width: 50%">
                                <label for="" class="form-label small">Jenis Dokumen</label>
                                <p class="text-muted">{{ $document->namajenis }}</p>
                            </div>
                            <div class="dept" style="width: 50%">
                                <label for="" class="form-label small">Department</label>
                                <p class="text-muted">{{ $document->namadept }}</p>
                            </div>
                        </div>

                        <div class="col-10 d-flex p-0 mt-3 justify-content-between">
                            <div class="jenis-dok" style="width: 50%">
                                <label for="" class="form-label small">Tanggal Berlaku</label>
                                <p class="text-muted">
                                    {{ \Carbon\Carbon::parse($document->tanggal_berlaku)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div class="dept" style="width: 50%">
                                <label for="" class="form-label small">Tanggal
                                    Review</label>
                                <p class="text-muted">
                                    {{ \Carbon\Carbon::parse($document->tanggal_berlaku)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex p-0 mt-3">
                            <div class="status">
                                <label class="form-label small">Status Dokumen</label>
                                <div>
                                    @if ($document->statusdocument == '2')
                                        <span class="badge bg-info" style="color: #fff">Approved</span>
                                    @elseif($document->statusdocument == '1')
                                        <span class="badge bg-warning" style="color: #ffffff"><i
                                                class="fas fa-clock mr-1"></i>
                                            Waiting Approval</span>
                                    @elseif($document->statusdocument == '3')
                                        <span class="badge bg-success" style="color: #fff">Published</span>
                                    @elseif($document->statusdocument == '4')
                                        <span class="badge bg-danger" style="color: #fff">Obsolete</span>
                                    @elseif($document->statusdocument == '5')
                                        <span class="badge bg-danger" style="color: #fff">Archived</span>
                                    @else
                                        <span class="badge bg-secondary"
                                            style="color: #fff">{{ $document->statusdocument }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="status">
                                <label class="form-label small">Assigned To</label>
                                <div>
                                    @if ($document->approval == null)
                                        <span style="color: #080808; font-weight:bold;">Unassigned</span>
                                    @else
                                        @if ($document->uavatar)
                                            <img src="{{ asset('assets/img/avatar/' . $document->uavatar) }}"
                                                class="rounded-circle me-2" width="36" height="36"
                                                alt="{{ $document->approval }}"
                                                onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.svg') }}'">
                                        @else
                                            <div class="rounded-circle {{ $randomColor }} text-white d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; font-size: 0.8rem;">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <span style="color: #040404; margin-left: 5px;">{{ $document->uname }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="status mt-3">
                            <label class="form-label small">Created By</label>
                            <div><span class="badge bg-info" style="color: #ffffff">{{ $document->created }}</span></div>
                        </div>
                    </div>
                </div>

                {{-- Card: Distribusi --}}
                <div class="card m-4 shadow">
                    <div class="title">
                        <p>Document Distribusi</p>
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
                <div class="card m-4 shadow">
                    <div class="title">
                        <p>Document Files</p>
                    </div>
                    <div class="card-body">
                        {{-- Tab Header --}}
                        <ul class="nav nav-tabs mb-3" id="customFieldTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="instruksi-tab" data-bs-toggle="tab"
                                    data-bs-target="#instruksi" type="button" role="tab">Instruksi Kerja</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="formulir-tab" data-bs-toggle="tab"
                                    data-bs-target="#formulir" type="button" role="tab">Formulir</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="diagram-tab" data-bs-toggle="tab" data-bs-target="#diagram"
                                    type="button" role="tab">Diagram Alir</button>
                            </li>
                            <!-- Tambah tab lainnya sesuai kebutuhan -->
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="instruksi" role="tabpanel">
                                <div class="border rounded p-2">
                                    <div id="previewDocumentInstruksi" class="mt-2 small file-grid">
                                        @foreach ($path_document as $file)
                                            @php
                                                $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                $icon = '';
                                                if (in_array($ext, ['pdf'])) {
                                                    $icon = asset('assets/img/icon/pdf.svg');
                                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                                    $icon = asset('assets/img/icon/docx.svg');
                                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                                    $icon = asset('assets/img/icon/xlsx.svg');
                                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                                    $icon = asset('storage/documents' . $file->path); // preview gambar
                                                } else {
                                                    $icon = asset('assets/img/icon/file.svg');
                                                }
                                            @endphp

                                            <div class="file-card">
                                                <a href="{{ asset('storage/documents' . $file->path) }}" target="_blank"
                                                    class="file-link">
                                                    <img src="{{ $icon }}" alt="file icon" class="file-icon">
                                                    <div class="file-title">{{ $file->name }}</div>
                                                </a>

                                                @auth
                                                    @if (auth()->user()->role_id == 1)
                                                        <form action="{{ route('docs_qualityprocedure.destroy', $file->id) }}"
                                                            method="POST" class="delete-form"
                                                            onClick="event.stopPropagation();">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-btn" id="btn-delete">
                                                                <i class="fas fa-trash icon-delete"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="formulir" role="tabpanel">
                                <div class="border rounded p-2">
                                    <div id="previewDocumentFormulir" class="mt-2 small file-grid">
                                        @foreach ($path_form as $file)
                                            @php
                                                $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                $icon = '';
                                                if (in_array($ext, ['pdf'])) {
                                                    $icon = asset('assets/img/icon/pdf.svg');
                                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                                    $icon = asset('assets/img/icon/docx.svg');
                                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                                    $icon = asset('assets/img/icon/xlsx.svg');
                                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                                    $icon = asset('storage/documents' . $file->path); // preview gambar
                                                } else {
                                                    $icon = asset('assets/img/icon/file.svg');
                                                }
                                            @endphp

                                            <div class="file-card">
                                                <a href="{{ asset('storage/documents' . $file->path) }}" target="_blank"
                                                    class="file-link">
                                                    <img src="{{ $icon }}" alt="file icon" class="file-icon">
                                                    <div class="file-title">{{ $file->name }}</div>
                                                </a>

                                                @auth
                                                    @if (auth()->user()->role_id == 1)
                                                        <form action="{{ route('docs_qualityprocedure.destroy', $file->id) }}"
                                                            method="POST" class="delete-form"
                                                            onClick="event.stopPropagation();">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-btn" id="btn-delete">
                                                                <i class="fas fa-trash icon-delete"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="diagram" role="tabpanel">
                                <div class="border rounded p-2">
                                    <div id="previewDocumentDiagram" class="mt-2 small file-grid">
                                        @foreach ($path_diagram as $file)
                                            @php
                                                $ext = pathinfo($file->path, PATHINFO_EXTENSION);
                                                $icon = '';
                                                if (in_array($ext, ['pdf'])) {
                                                    $icon = asset('assets/img/icon/pdf.svg');
                                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                                    $icon = asset('assets/img/icon/docx.svg');
                                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                                    $icon = asset('assets/img/icon/xlsx.svg');
                                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                                    $icon = asset('storage/documents' . $file->path); // preview gambar
                                                } else {
                                                    $icon = asset('assets/img/icon/file.svg');
                                                }
                                            @endphp

                                            <div class="file-card">
                                                <a href="{{ asset('storage/documents' . $file->path) }}" target="_blank"
                                                    class="file-link">
                                                    <img src="{{ $icon }}" alt="file icon" class="file-icon">
                                                    <div class="file-title">{{ $file->name }}</div>
                                                </a>

                                                @auth
                                                    @if (auth()->user()->role_id == 1)
                                                        <form action="{{ route('docs_qualityprocedure.destroy', $file->id) }}"
                                                            method="POST" class="delete-form"
                                                            onClick="event.stopPropagation();">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-btn" id="btn-delete">
                                                                <i class="fas fa-trash icon-delete"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endforeach
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
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .file-card {
        position: relative;
        width: 250px;
        height: 210px;
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: 0.2s ease-in-out;
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
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .file-title {
        font-size: 13px;
        font-weight: 500;
        max-height: 70px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        word-break: break-word;
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
        /* Ukuran icon diperbesar */
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
        margin: 20px 20px;
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
        handleFilePreview('filesDocumentInstruksi', 'previewDocumentInstruksi', 'countFilesDocumentInstruksi',
            'getFilesDocumentInstruksi');
        handleFilePreview('filesDocumentFormulir', 'previewDocumentFormulir', 'countFilesDocumentFormulir',
            'getFilesDocumentFormulir');
        handleFilePreview('filesDocumentDiagram', 'previewDocumentDiagram',
            'countFilesDocumentDiagram', 'getFilesDocumentDiagram');
    });
</script>
