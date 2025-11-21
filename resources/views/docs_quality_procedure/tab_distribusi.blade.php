<div id="distribusi" class="tab-content-custom m-4">
    <div class="form-group">
        <div class="mb-2" id="custom">
            <div class="left">
                <input type="checkbox" id="selectAll" />
                <label for="selectAll" style="font-weight: bold;">Pilih Semua</label>
            </div>
        </div>
        <div class="user-checkbox-list"
            style="border: 1px solid #ced4da; border-radius: 5px; max-height: 400px; overflow-y: auto; padding: 10px;">
            @foreach ($users as $position => $userGroup)
                <div class="title" style="font-weight: bold">{{ $position }}</div>
                <div class="checkbox-grid d-flex flex-wrap">
                    @foreach ($userGroup as $user)
                        <div class="form-check d-flex m-3">
                            <input class="form-check-input user-checkbox" type="checkbox" name="distribusi_users[]"
                                value="{{ $user->id }}" id="user{{ $user->id }}"
                                @if (isset($selectedUsers) && in_array($user->id, $selectedUsers)) checked @endif>
                            <label class="form-check-label" for="user{{ $user->id }}">
                                {{ $user->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    <div class="card-footer text-end d-flex justify-content-between">
        <button type="button" class="btn btn-warning btn-lg btn-route me-2 prev-tab"
            data-target="files">Kembali</button>
        <button type="submit" class="btn btn-success btn-lg btn-route">Simpan</button>
    </div>
</div>

<style>
    /* Custom Checkbox Style */
    .form-check {
        position: relative;
        min-height: 2rem;
        padding-left: 2.5rem;
    }

    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        margin-top: 0;
        margin-left: -2.5rem;
        border: 2px solid #adb5bd;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        outline: none;
    }

    .form-check-label {
        padding-top: 0.15rem;
        font-size: 1rem;
        cursor: pointer;
    }

    /* Select All Checkbox */
    #selectAll {
        width: 1.5rem;
        height: 1.5rem;
        margin-right: 0.75rem;
        vertical-align: middle;
    }

    .left label {
        font-size: 1.1rem;
        cursor: pointer;
        vertical-align: middle;
    }

    /* Hover Effects */
    .form-check-input:hover {
        cursor: pointer;
        transform: scale(1.05);
    }

    /* Checkbox Grid Layout */
    .checkbox-grid {
        gap: 1rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .checkbox-grid {
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-check {
            padding-left: 2rem;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
        }
    }
</style>
