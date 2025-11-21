@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card p-3">
                    <div class="row ml-3 mr-3">
                        <i class="fas fa-chalkboard-teacher mt-2" style="color: #020d71; font-size: 20px;"></i>
                        <h2 class="title-body mt-1 ml-3">
                            Instruksi Kerja
                        </h2>

                    </div>
                </div>
                <div class="dtb-header ml-4 mr-3">
                    <div id="entries-container" class="mt-2"></div>
                    <div class="col-6 d-flex justify-content-end">
                        <select id="categoryFilter" class="form-control m-1" style="width: 200px;">
                            <option value="">Select Category</option>
                            @foreach ($masterdocs as $md)
                                <option value="{{ $md->name }}">{{ $md->name }}</option>
                            @endforeach
                        </select>
                        <select id="departmentFilter" class="form-control m-1" style="width: 200px;">
                            <option value="">Select Department</option>
                            @foreach ($departments as $depart)
                                <option value="{{ $depart->name }}">{{ $depart->name }}</option>
                            @endforeach
                        </select>
                        <input type="search" class="form-control m-1" id="searchInput" placeholder="Search..."
                            style="width: 200px;">
                    </div>
                </div>

                <div class="row ml-1 mr-1">
                    <div class="card-body ml-4 mr-4 p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="documentTable">
                                <thead class="custom-table">
                                    <tr class="header">
                                        <th>No</th>
                                        <th>No Prosedur</th>
                                        <th>Nama Dokumen</th>
                                        <th>Kode Dokumen</th>
                                        <th>Mark Dokumen</th>
                                        <th>Effective Date</th>
                                        <th>Review Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="td">{{ $loop->iteration }}</td>
                                            <td class="td">{{ $item->nodocument }}</td>
                                            <td class="td">{{ $item->namadocument }}</td>
                                            <td class="td">{{ $item->file_code }}</td>
                                            <td class="td">
                                                @switch($item->mark_dokumen)
                                                    @case('Confidential')
                                                        <span style="color: #f70c0c; font-weight: bold;">Confidential</span>
                                                    @break

                                                    @case('Internal')
                                                        <span style="color: #e65022; font-weight: bold;">Internal</span>
                                                    @break

                                                    @case('Restricted')
                                                        <span style="color: #f1bc0f; font-weight: bold;">Restricted</span>
                                                    @break

                                                    @case('Public')
                                                        <span style="color: #27ae5fcc; font-weight: bold;">Public</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-light">?</span>
                                                @endswitch
                                            </td>
                                            <td class="td">{{ $item->tanggal_berlaku }}</td>
                                            <td class="td">{{ $item->tanggal_review }}</td>
                                            <td class="td">
                                                @switch($item->statusdocument)
                                                    @case('3')
                                                        <span class="badge bg-success" style="color: white;">Active</span>
                                                    @break

                                                    @case('4')
                                                        <span class="badge bg-danger" style="color: white;">Expired</span>
                                                    @break

                                                    @case('5')
                                                        <span class="badge bg-warning" style="color: white;">Archive</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-light">?</span>
                                                @endswitch

                                            </td>
                                            <td class="td">
                                                @php
                                                    $filePath = 'instruksi/' . $item->path;
                                                @endphp

                                                </a>
                                                <a href="{{ route('file.view', ['filename' => $item->path]) }}"
                                                    target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                <a href="{{ Storage::url($filePath) }}" download
                                                    class="btn btn-sm btn-success">
                                                    <i class="fas fa-download"></i> Download
                                                </a>

                                                @if (Auth::user() && Auth::user()->role->name == 'SuperAdmin')
                                                    <form
                                                        action="{{ route('document.delete', ['nodocument' => $item->nodocument, 'filecode' => $item->file_code]) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
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
    <x-modal-detail category="workinstruction" />
@endsection


<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $("#documentTable").DataTable({
            paging: true,
            searching: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ordering: true,
            info: true,
            responsive: true,
            language: {
                paginate: {
                    previous: "<",
                    next: ">",
                }
            }
        });


        $("#entries-container").append($(".dataTables_length"));

        $("#searchInput").on("keyup", function() {
            var searchTerm = this.value;
            table.search(searchTerm).draw();
        });

        $("#categoryFilter").on("change", function() {
            var selectedJenis = this.value;
            table.column(2).search(selectedJenis).draw();
        });

        $("#departmentFilter").on("change", function() {
            var selectedDepartment = this.value;
            table.column(4).search(selectedDepartment).draw();
        });

        $("#entries").on("change", function() {
            var length = $(this).val();
            table.page.len(length).draw();
        });

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
    .dtb-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    #entries-container {
        order: -1;
    }

    .header {
        background: #f5f9ff;
        font-size: 14px;
        font-weight: bold;
    }

    .td {
        color: #6f6e6e;
    }

    .dataTables_filter {
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
        cursor: pointer;
        font-weight: bold;
        color: #333;
        transition: all 0.3s ease-in-out;
    }

    .dataTables_length select:hover {
        background: #e9ecef;
        border-color: #999;
    }
</style>
