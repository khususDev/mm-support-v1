<div class="tab-pane fade" id="sasaran" role="tabpanel">
    <div class="border rounded p-2">
        <div id="previewDocumentSasaran" class="mt-2 small file-grid">
            @forelse ($sasaran as $file)
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
                        $icon = asset('storage/' . $file->url);
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
            @empty
                <div class="col-12">
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-folder-open fa-3x mb-2"></i>
                        <p class="mb-0" style="font-size: large">Tidak ada file ditemukan.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
