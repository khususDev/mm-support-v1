$(document).ready(function () {
    // Inisialisasi DataTable
    var table = $("#documentTable").DataTable({
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        lengthChange: false,
    });
    $("#searchInput").on("keyup", function () {
        var searchTerm = this.value;
        table.search(searchTerm).draw(); // Menghubungkan input custom ke DataTable
    });

    // Custom filter for category selection
    $("#categoryFilter").on("change", function () {
        var selectedCategory = this.value;
        table.column(1).search(selectedCategory).draw();
    });

    // Tangani klik pada tombol untuk melihat dokumen
    $(document).on("click", ".view-document", function () {
        var documentId = $(this).data("id"); // Mendapatkan ID dokumen yang sudah terenkripsi

        console.log("Request URL: /mmqa/" + documentId); // Menambahkan log untuk memeriksa URL yang dikirimkan

        $.ajax({
            url: "/mmqa/" + documentId, // Langsung gunakan route resource yang sudah benar
            type: "GET",
            success: function (response) {
                console.log(response); // Periksa respons yang diterima dari server
                var data = response.data; // Data yang diterima dari server

                // Menampilkan data ke dalam modal
                $("#myModal").on("show.bs.modal", function (e) {
                    $("#modalNodocs").text(data.nodocs); // Nama dokumen
                    $("#modalNama").text(data.namadocs); // Nama dokumen
                    $("#modalCategory").text(data.namajenis); // Nama dokumen
                    $("#modalDescription").text(data.desc); // Deskripsi dokumen
                    $("#modalPath").text(data.path); // Path dokumen
                    $("#modalBerlaku").text(data.berlaku); // Tanggal berlaku dokumen
                    $("#modalRevisi").text(data.revisi); // Revisi dokumen
                    $("#modalStatus").text(data.status); // Status dokumen
                    $("#modalVerified").text(data.verified); // Verifikator
                    $("#modalDept").text(data.namadept); // Nama department
                });

                // Tampilkan modal
                $("#myModal").modal("show");
                $("#myModal").prependTo("body");
                $("#myModal").on("shown.bs.modal", function () {
                    $(".modal-backdrop").css("pointer-events", "none");
                });
                $("#myModal").on("hidden.bs.modal", function () {
                    $(".modal-backdrop").css("pointer-events", "auto");
                });
                $("#myModal").on("shown.bs.modal", function () {
                    $("#myModal").trigger("focus");
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            },
        });
    });
});
