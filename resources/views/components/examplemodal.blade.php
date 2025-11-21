@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-3">
                    <div class="row ml-3 mr-3 d-flex justify-content-between">
                        <div class="title d-flex justify-content-center">
                            <i class="fas fa-book-open mt-2" style="color: #020d71; font-size: 20px;"></i>
                            <h2 class="title-body ml-3 mt-1">
                                External Document
                            </h2>
                        </div>
                        <div class="action">
                            <a href="{{ route('docs_qualityprocedure.create') }}" class="btn btn-primary" id="btn-create"><i
                                    class="fas fa-plus-square"></i> Upload Document</a>
                            <a href="{{ route('docs_qualityprocedure.create') }}" class="btn btn-secondary ml-2"
                                id="btn-create" style="color: #333"><i class="fas fa-plus-square"></i> Manual
                                Document</a>
                            {{-- <button data-bs-toggle="modal" data-bs-target="#detailModal" id="button">Modal</button> --}}
                            <button class="btn btn-info" id="button">Modal</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" data-modal-category="{{ $category ?? 'default' }}">
                <div class="modal-header">
                    <p class="title-body modal-title" id="detailModalLabel">Detail Document</p>
                    <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">×</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#button").on("click", function() {
            $("#detailModal").modal("show");
            $("#detailModal").prependTo("body");

            $("#detailModal").on("shown.bs.modal", function() {
                $("#detailModal").trigger("focus");
            });
        });
    });
</script>

<style>
    .header {
        background: #f5f9ff;
        font-size: 14px;
        font-weight: bold;
    }

    body.modal-open {
        padding-right: 0 !important;
    }

    .modal-backdrop {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 1040 !important;
    }

    .modal-content {
        background-color: #fff !important;
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        top: 10%;
        left: 10%;
    }
</style>
