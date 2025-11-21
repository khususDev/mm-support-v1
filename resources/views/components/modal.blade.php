<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-primary"
                    onclick="window.location='{{ route('sop.detail', Crypt::encryptString($item->nodocument)) }}'">
                    See Details
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        background: none;
        border: none;
        font-size: 20px;
        font-weight: bold;
        color: #000;
        cursor: pointer;
    }

    .custom-close-btn:hover {
        color: red;
    }
</style>

<script>
    console.log(@json($id));
</script>
