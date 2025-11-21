@props([
    'title' => 'Tambah File',
    'action' => route('external_folder.upload'),
    'users' => [],
    'location_id' => '',
    'oldUsers' => [], // 'simple' atau 'detail'
])

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            {{-- <input type="hidden" name="folder_id" value="{{ $folder->id }}"> --}}

            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="form-group">
                <input type="hidden" name="location_id" value="{{ $location_id }}">
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="file">Pilih File:</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
