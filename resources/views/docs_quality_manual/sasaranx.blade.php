<div id="sasaran" class="tab-content-custom m-4">
    <div class="card-body p-2">
        <div class="col-3">
            <div class="row justify-content-between">
                <img src="{{ asset('assets/img/icon/pdf.svg') }}" alt="" style="width:50px;">
                <img src="{{ asset('assets/img/icon/xlsx.svg') }}" alt="" style="width:50px;">
                <img src="{{ asset('assets/img/icon/docx.svg') }}" alt="" style="width:50px;">
                <img src="{{ asset('assets/img/icon/png&jpg.png') }}" alt=""
                    style="width:40px; margin: 10px; zoom: 1.5;">
            </div>
            <p style="color: rgb(25, 60, 218)">You can upload file jpg, png, pdf,
                doc, docx,
                xls, xlsx</p>
        </div>
        <div class="row">
            {{-- Document Upload --}}
            <div class="col-md-12">
                <div class="col-3">
                    <label class="form-label">Upload Multiple Document</label>
                    <label class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                        Choose Files
                        <input type="file" id="filesDocumentSasaran" multiple hidden> <span
                            id="countFilesDocumentSasaran" class="text-muted small d-block">0 files</span>
                    </label>

                </div>

                <div class="border rounded p-2">
                    <div id="previewDocumentSasaran" class="mt-2 small file-grid">
                        @foreach ($sasaran as $file)
                            @php
                                $ext = pathinfo($file->url, PATHINFO_EXTENSION);
                                $icon = '';
                                if (in_array($ext, ['pdf'])) {
                                    $icon = asset('assets/img/icon/pdf.svg');
                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                    $icon = asset('assets/img/icon/docx.svg');
                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                    $icon = asset('assets/img/icon/xlsx.svg');
                                } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                    $icon = asset('storage/' . $file->url); // preview gambar
                                } else {
                                    $icon = asset('assets/img/icon/file.svg');
                                }
                            @endphp

                            <div class="file-card">
                                <a href="{{ asset('storage/' . $file->url) }}" target="_blank" class="file-link">
                                    <img src="{{ $icon }}" alt="file icon" class="file-icon">
                                    <div class="file-title">{{ $file->title }}</div>
                                </a>

                                @auth
                                    @if (auth()->user()->role_id == 1)
                                        <form action="{{ route('docs_qualitymanual.destroy', $file->id) }}" method="POST"
                                            class="delete-form" onClick="event.stopPropagation();">
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
