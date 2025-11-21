@props(['category'])

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content" data-modal-category="{{ $category ?? 'default' }}">
            <div class="modal-header">
                <p class="title-body modal-title" id="detailModalLabel">Detail Document</p>
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="px-4">
                    <div class="row">
                        <div class="col" style="display: none">
                            <label for="">No Document Hidden</label>
                            <h6 id="modalNodocsHide"></h6>
                        </div>
                        <div class="col">
                            <label for="">No Document</label>
                            <h6 id="modalNodocs"></h6>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="">Nama Document</label>
                        <h6 id="modalNama"></h6>
                    </div>
                    <div class="mt-4">
                        <label for="">Description Document</label>
                        <p id="modalDescription" class="font-weight-bold"></p>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="">Department</label>
                            <h6 id="modalDept"></h6>
                        </div>

                        <div class="col">
                            <label for="">Category</label>
                            <h6 id="modalCategory"></h6>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="">Instruksi Kerja</label>
                            <h6 id="modalInstruksi"></h6>
                        </div>

                        <div class="col">
                            <label for="">Formulir</label>
                            <h6 id="modalForm"></h6>
                        </div>
                        <div class="col">
                            <label for="">Diagram</label>
                            <h6 id="modalDiagram"></h6>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="">Status Document</label>
                        <p id="modalStatus" class="font-weight-bold"></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <h5 class="badge bg-warning" id="keterangan" style="color: rgb(4, 4, 4)"></h5>
                    <button type="button" class="btn btn-primary btn-see-detail d-none" id="btn_det">
                        See Details
                    </button>
                    <button type="button" class="btn btn-success d-none" id="btn_approve">
                        Approved
                    </button>
                    <button type="button" class="btn btn-danger d-none" id="btn_reject">
                        Rejected
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modelDetail = document.getElementById('detailModal');
            const approveButton = document.getElementById('btn_approve');
            const rejectButton = document.getElementById('btn_reject');
            let currentEncryptedNoDoc = null;

            // Fungsi untuk reset modal
            function resetModal() {
                // Reset semua field konten
                document.getElementById('modalNodocs').textContent = '';
                document.getElementById('modalNama').textContent = '';
                document.getElementById('modalDescription').textContent = '';
                document.getElementById('modalDept').textContent = '';
                document.getElementById('modalCategory').textContent = '';
                document.getElementById('modalInstruksi').textContent = '';
                document.getElementById('modalForm').textContent = '';
                document.getElementById('modalDiagram').textContent = '';
                document.getElementById('modalStatus').textContent = '';

                // Reset semua tombol dan keterangan
                const seedetbtn = document.getElementById('btn_det');
                const txtKeterangan = document.getElementById('keterangan');

                seedetbtn.classList.add("d-none");
                approveButton.classList.add("d-none");
                rejectButton.classList.add("d-none");
                txtKeterangan.textContent = "";
                txtKeterangan.classList.add("d-none");
            }

            modelDetail.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                currentEncryptedNoDoc = button.getAttribute('data-nodocs');
                // Proses status dan tombol
                var isApprover = button.getAttribute('data-approver');
                var isStatus = button.getAttribute('data-status');
                var isUser = button.getAttribute('data-userid');
                var isRole = button.getAttribute('data-userrole');

                const seedetbtn = document.getElementById('btn_det');
                const txtKeterangan = document.getElementById('keterangan');

                // Pastikan semua elemen reset sebelum di-set ulang
                seedetbtn.classList.add("d-none");
                approveButton.classList.add("d-none");
                rejectButton.classList.add("d-none");
                txtKeterangan.textContent = "";
                txtKeterangan.classList.remove("d-none");

                // Logika status
                switch (isStatus) {
                    case 'Published':
                        seedetbtn.classList.remove("d-none");
                        txtKeterangan.classList.add("d-none");
                        break;

                    case 'Approved':
                        txtKeterangan.textContent = "Document bisa digunakan sesuai tanggal berlaku.";
                        break;

                    case 'Obsolete':
                        if (isRole !== 'Admin') {
                            txtKeterangan.textContent = "Hubungi Administrator jika ada perubahan!";
                        } else {
                            seedetbtn.classList.remove("d-none");
                            txtKeterangan.classList.add("d-none");
                        }
                        break;

                    case 'Archived':
                        if (isRole !== 'Admin') {
                            txtKeterangan.textContent = "Hubungi Administrator jika ada perubahan!";
                        } else {
                            seedetbtn.classList.remove("d-none");
                            txtKeterangan.classList.add("d-none");
                        }
                        break;

                    case 'Waiting':
                        if (isUser === isApprover) {
                            seedetbtn.classList.remove("d-none");
                            approveButton.classList.remove("d-none");
                            rejectButton.classList.remove("d-none");
                            txtKeterangan.classList.add("d-none");
                        }
                        break;

                    default:
                        console.log('Status tidak dikenali:', isStatus);
                }
            });

            // Fungsi Approve
            approveButton.addEventListener('click', function() {
                if (!currentEncryptedNoDoc) return;

                if (!confirm('Anda yakin ingin menyetujui dokumen ini?')) {
                    return;
                }

                fetch(`/docs_qualityprocedure/${encodeURIComponent(currentEncryptedNoDoc)}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyetujui dokumen');
                    });
            });

            // Fungsi Reject
            rejectButton.addEventListener('click', function() {
                if (!currentEncryptedNoDoc) return;

                if (!confirm('Anda yakin ingin menolak dokumen ini?')) {
                    return;
                }

                fetch(`/docs_qualityprocedure/${encodeURIComponent(currentEncryptedNoDoc)}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menolak dokumen');
                    });
            });

            document.querySelector(".btn-see-detail").addEventListener("click", function() {
                let nodocument = document.getElementById("modalNodocsHide").innerText.trim();
                let modalContent = document.querySelector("#detailModal .modal-content");

                if (!modalContent) {
                    console.error("ModalContent tidak ditemukan!");
                    alert("Category tidak ditemukan!");
                    return;
                }

                let category = modalContent.getAttribute("data-modal-category");
                console.log("Data category:", category);

                if (!category) {
                    alert("Category tidak ditemukan!");
                    return;
                }

                if (nodocument) {
                    window.location.href = `/${category}/${nodocument}/detail`;
                } else {
                    alert("No document selected!");
                }
            });
        });
    </script>

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
