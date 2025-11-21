@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-4">
                    <h2 class="title-body">
                        Standard Operating Procedure
                    </h2>
                </div>
                <div class="row justify-content-between ml-3 mr-3">
                    <div class="col-md-6">
                        <a href="{{ route('sop.create') }}" class="btn btn-primary" id="btn-create"><i
                                class="fas fa-file-upload"></i> Upload
                            Documents</a>
                        <a href="{{ route('sop.create') }}" class="btn btn-secondary" id="btn-create"><i
                                class="fas fa-plus-square"></i> Manual
                            Documents</a>
                    </div>

                    <div class="col-md-5 d-flex">
                        <select id="categoryFilter" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($masterdocs as $md)
                                <option value="{{ $md->name }}">{{ $md->name }}</option>
                            @endforeach
                        </select>
                        <select id="departmentFilter" class="form-control ml-1">
                            <option value="">Select Department</option>
                            @foreach ($departments as $depart)
                                <option value="{{ $depart->name }}">{{ $depart->name }}</option>
                            @endforeach
                        </select>
                        <input type="search" class="form-control ml-1" id="searchInput" placeholder="Search...">
                    </div>
                </div>
                <div class="row ml-1 mr-1 mb-1">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="documentTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Document Number</th>
                                        <th>Document Name</th>
                                        <th>Category</th>
                                        <th>Department</th>
                                        <th>Effective Date</th>
                                        <th>Review Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nodocument }}</td>
                                            <td>{{ $item->namadocument }}</td>
                                            <td>{{ $item->jenis_document }}</td>
                                            <td>
                                                @switch($item->deptcode)
                                                    @case('QA')
                                                        <span class="badge bg-badge1" style="color: black">Quality Assurance</span>
                                                    @break

                                                    @case('IT')
                                                        <span class="badge bg-badge3" style="color: black;">Information
                                                            Technology</span>
                                                    @break

                                                    @case('GA')
                                                        <span class="badge bg-badge4" style="color: black;">General Affair</span>
                                                    @break

                                                    @case('TS')
                                                        <span class="badge bg-badge2" style="color: black;">Technical Support</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-badge3">?</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $item->tanggal_berlaku }}</td>
                                            <td>{{ $item->tanggal_review }}</td>
                                            <td>
                                                @switch($item->status)
                                                    @case('Published')
                                                        <span class="badge bg-success" style="color: white">Published</span>
                                                    @break

                                                    @case('Obsolete')
                                                        <span class="badge bg-danger" style="color: white;">Obsolete</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-light">?</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <form action="{{ route('sop.destroy', $item->id) }}" method="POST"
                                                    id="delt{{ $item->id }}">
                                                    <a href="#" class="btn btn-secondary view-document"
                                                        data-id="{{ $item->id }}"
                                                        data-nodocs="{{ Crypt::encryptString($item->nodocument) }}"
                                                        data-nodocument="{{ $item->nodocument }}"
                                                        data-namadocument="{{ $item->namadocument }}"
                                                        data-deskripsi="{{ $item->deskripsi }}"
                                                        data-department="{{ $item->department }}"
                                                        data-categori="{{ $item->jenis_document }}"
                                                        data-status="{{ $item->status }}"
                                                        data-form="{{ $item->total_path_form }}"
                                                        data-document="{{ $item->total_path_document }}"
                                                        data-bs-toggle="modal" data-bs-target="#detailModal">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmDelete(<?= $item->id ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal-detail />
@endsection


<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/bootstrap.bundle.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $("#documentTable").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            responsive: true,
            language: {
                paginate: {
                    previous: "<",
                    next: ">",
                }
            }
        });

        $("#searchInput").on("keyup", function() {
            var searchTerm = this.value;
            table.search(searchTerm).draw();
        });

        $("#categoryFilter").on("change", function() {
            var selectedCategory = this.value;
            table.column(3).search(selectedCategory).draw();
        });

        $("#departmentFilter").on("change", function() {
            var selectedDepartment = this.value;
            table.column(4).search(selectedDepartment).draw();
        });

        // **Event Delegation agar tetap aktif setelah filter**
        $("#documentTable tbody").on("click", ".view-document", function() {
            let nodocs = $(this).data("nodocument");
            let nodocshide = $(this).data("nodocs");
            let namadocument = $(this).data("namadocument");
            let categori = $(this).data("categori");
            let deskripsi = $(this).data("deskripsi");
            let department = $(this).data("department");
            let totaldocument = $(this).data("document");
            let totalform = $(this).data("form");
            let status = $(this).data("status");

            console.log("Data yang masuk ke modal:", {
                nodocs,
                nodocshide,
                namadocument,
                categori,
                deskripsi,
                department,
                totaldocument,
                totalform,
                status
            });

            $("#modalNodocs").text(nodocs);
            $("#modalNodocsHide").text(nodocshide);
            $("#modalNama").text(namadocument);
            $("#modalDescription").text(deskripsi);
            $("#modalDept").text(department);
            $("#modalCategory").text(categori);
            $("#modalDocument").text(totaldocument);
            $("#modalForm").text(totalform);
            $("#modalStatus").text(status);

            $("#detailModal").modal("show");
            $("#detailModal").prependTo("body");
            $("#detailModal").on("shown.bs.modal", function() {
                $(".modal-backdrop").css("pointer-events", "none");
            });
            $("#detailModal").on("hidden.bs.modal", function() {
                $(".modal-backdrop").css("pointer-events", "auto");
            });
            $("#detailModal").on("shown.bs.modal", function() {
                $("#detailModal").trigger("focus");
            });
        });
    });
</script>

<style>
    div.dataTables_filter {
        display: none;
    }

    .table tr td {
        font-size: 14px;
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

    .filter-container {
        border: 2px solid red;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9f9f9;
        margin-top: 10px;
    }

    .filter-header h5 {
        margin: 0;
        padding-bottom: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 8px;
    }

    .filter-body {
        display: flex;
        gap: 10px;
    }

    .form-control {
        font-size: 16px;
        padding: 8px;
    }

    .dataTables_length {
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #555;
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dataTables_length select {
        width: 80px;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background: #f8f9fa;
        /* Warna background biar soft */
        cursor: pointer;
        font-weight: bold;
        color: #333;
        transition: all 0.3s ease-in-out;
    }

    .dataTables_length select:hover {
        background: #e9ecef;
        /* Hover efek */
        border-color: #999;
    }
</style>
