var Index = (function () {
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;

    // fungsi kirim data form via ajx
    var handleKategoriSave = function () {
        $("#kategorispesertas").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                type: "POST",
                url: url + "/admin/kategori-peserta",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success("Data Berhasil Disimpan", "Success");
                    setTimeout(() => {
                        $("#modalTambahKategoriPeserta").modal("toggle");
                        table.ajax.reload();
                    }, 1000);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };

    // fungsi menampilkan data ditabel menggunakan datatable
    var handleData = function () {
        table = $("#tableKtgPeserta").DataTable({
            responsive: true,
            autoWidth: true,
            pageLength: 10,
            searching: true,
            paging: true,
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50],
            ],
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                infoFiltered: "",
                zeroRecords: "Data tidak di temukan",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnsDefs: [
                { searchable: false, target: [0, 1] },
                { orderable: false, target: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/admin/kategori-pesertas",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "nama", orderable: false },
                { data: "action", orderable: false },
            ],
        });
    };

    // fungsi hapus data
    var handleDelete = function () {
        $(document).on("click", ".kategori-deletes", function () {
            const dataButtonDelete = $(this).data("btndelete");
            if (
                confirm(
                    "Apakah anda yakin? data yang terhapus tidak bisa dikembalikan!"
                )
            ) {
                $.ajax({
                    type: "DELETE",
                    url: url + "/admin/kategori-peserta/" + dataButtonDelete,
                    data: {
                        _token: csrf_token,
                    },
                    success: function (response) {
                        toastr.success("Data Dihapus!", "Success");
                        setTimeout(() => {
                            table.ajax.reload();
                        }, 1500);
                    },
                });
            }
        });
    };
    return {
        init: function () {
            handleKategoriSave();
            handleData();
            handleDelete();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
