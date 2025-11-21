function confirmDelete(id) {
    Swal.fire({
        title: "Hapus Data?",
        text: "Apakah Anda yakin ingin menghapus data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delt" + id).submit();
        }
    });
}

("use strict");
