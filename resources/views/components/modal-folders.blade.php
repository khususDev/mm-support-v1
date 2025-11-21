@props([
    'title' => 'Tambah Folder',
    'action' => route('external_folder.new_folder'),
    'users' => [],
    'location_id' => '',
    'oldUsers' => [], // 'simple' atau 'detail'
])

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ $action }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Folder</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="location_id" value="{{ $location_id }}">
                    </div>

                    <div class="form">
                        <p for="selectAll" style="font-weight: bold; font-size: 12px;">Folder Access</p>
                        <input type="checkbox" id="selectAll" />
                        <label for="selectAll" style="font-size: 12px;">Pilih Semua</label>

                        <div class="user-checkbox-list"
                            style="border: 1px solid #ced4da; border-radius: 5px; padding: 10px; display: flex; flex-wrap: wrap;">
                            <div style="flex: 1; min-width: 50%;">
                                @foreach ($users->take(ceil(count($users) / 2)) as $user)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input user-checkbox" type="checkbox" name="users[]"
                                            value="{{ $user->id }}" id="user{{ $user->id }}"
                                            {{ in_array($user->id, $oldUsers) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user{{ $user->id }}">
                                            {{ $user->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div style="flex: 1; min-width: 50%;">
                                @foreach ($users->slice(ceil(count($users) / 2)) as $user)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input user-checkbox" type="checkbox" name="users[]"
                                            value="{{ $user->id }}" id="user{{ $user->id }}"
                                            {{ in_array($user->id, $oldUsers) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user{{ $user->id }}">
                                            {{ $user->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
