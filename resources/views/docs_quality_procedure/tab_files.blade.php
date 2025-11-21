<div id="files" class="tab-content-custom m-4">
    <div class="card-body p-2">
        <div class="col-6">
            <div class="row">
                <img src="{{ asset('assets/img/icon/pdf.svg') }}" alt="" style="width:40px; margin: 10px;">
                <img src="{{ asset('assets/img/icon/xlsx.svg') }}" alt="" style="width:40px; margin: 10px;">
                <img src="{{ asset('assets/img/icon/docx.svg') }}" alt="" style="width:40px; margin: 10px;">
            </div>
            <p style="color: rgb(25, 60, 218)">You can upload file pdf,
                doc, docx,
                xls, xlsx</p>
        </div>

        <div class="row">
            {{-- Document Upload --}}
            <div class="col-md-4">
                <label class="form-label">Upload Document</label>
                <div class="border rounded p-2">
                    <label class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                        Choose Files
                        <input type="file" id="filesDocument" multiple hidden>
                    </label>
                    <span id="countFilesDocument" class="text-muted small d-block text-center">0 files</span>
                    <div id="previewDocument" class="mt-2 small"></div>
                </div>
            </div>

            {{-- Form Upload --}}
            <div class="col-md-4">
                <label class="form-label">Upload Form</label>
                <div class="border rounded p-2">
                    <label class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                        Choose Files
                        <input type="file" id="filesForm" multiple hidden>
                    </label>
                    <span id="countFilesForm" class="text-muted small d-block text-center">0 files</span>
                    <div id="previewForm" class="mt-2 small"></div>
                </div>
            </div>

            {{-- Diagram Upload --}}
            <div class="col-md-4">
                <label class="form-label">Upload Diagram</label>
                <div class="border rounded p-2">
                    <label class="btn btn-outline-primary btn-sm w-100 mb-2 text-center">
                        Choose Files
                        <input type="file" id="filesDiagram" multiple hidden>
                    </label>
                    <span id="countFilesDiagram" class="text-muted small d-block text-center">0 files</span>
                    <div id="previewDiagram" class="mt-2 small"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end d-flex justify-content-between">
        <button type="button" class="btn btn-warning btn-lg btn-route me-2 prev-tab"
            data-target="data">Kembali</button>
        <button type="button" class="btn btn-primary btn-lg btn-route next-tab"
            data-target="distribusi">Lanjut</button>
    </div>
</div>

<style>
    .btn-route {
        width: 150px;
        height: 50px;
    }

    .file-card {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .file-card:hover {
        transform: scale(1.05);
    }

    .file-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 15px;
    }

    .file-info {
        flex: 1;
        overflow: hidden;
    }

    .file-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-remove {
        margin-left: 10px;
    }

    .file-preview-text-container {
        flex: 1;
        max-width: 400px;
        overflow: hidden;
    }

    .file-preview-text {
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
    }

    .tab-content {
        animation: fadeEffect 0.5s ease;
    }

    @keyframes fadeEffect {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
