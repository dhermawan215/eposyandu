var Index = (function () {
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    const peserta = $("#peserta").val();

    // fungsi menampilkan data ditabel menggunakan datatable
    var handleRiwayatPemeriksaanPeserta = function () {
        table = $("#tabelRiwayatPemeriksaan").DataTable({
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
                url: url + "/pemeriksaan/riwayat",
                type: "POST",
                data: {
                    _token: csrf_token,
                    peserta: peserta,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "tgl", orderable: false },
                { data: "n_pemeriksaan", orderable: false },
                { data: "h_pemeriksaan", orderable: false },
                { data: "ket", orderable: false },
            ],
        });
    };

    var handleSavePemeriksaan = function () {
        $("#formPemeriksaan").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                type: "POST",
                url: url + "/pemeriksaan",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#isLoading").removeClass("display-none");
                    $("#btnSimpanPemeriksaan").addClass("display-none");
                },
                success: function (response) {
                    toastr.success("Data Berhasil Disimpan", "Success");
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
                complete: function () {
                    $("#isLoading").addClass("display-none");
                    $("#btnSimpanPemeriksaan").removeClass("display-none");
                    $("#formPemeriksaan")[0].reset();
                    table.ajax.reload();
                },
            });
        });
    };

    return {
        init: function () {
            handleRiwayatPemeriksaanPeserta();
            handleSavePemeriksaan();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
