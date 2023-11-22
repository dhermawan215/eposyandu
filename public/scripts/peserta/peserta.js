var Index = (function () {
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;

    // fungsi menampilkan data ditabel menggunakan datatable
    var handleData = function () {
        table = $("#tabelPeserta").DataTable({
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
                url: url + "/pesertas",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "nomer", orderable: false },
                { data: "nama", orderable: false },
                { data: "action", orderable: false },
            ],
        });
        $("#tabelPeserta tbody").on("click", "tr", function () {
            // console.log(table.row(this).data());
            // handleEdit(table.row(this).data());
        });
    };

    // fungsi submit data
    var handlePesertaSave = function () {
        $("#formDaftarPesertaBaru").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                type: "POST",
                url: url + "/peserta",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success("Data Berhasil Disimpan", "Success");
                    setTimeout(() => {
                        document.location.href =
                            url + "/pemeriksaan/" + response.peserta;
                    }, 2000);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };

    var handleDetailData = function () {
        $(document).on("click", ".btn-view-detail", function (e) {
            e.preventDefault();
            const noPeserta = $(this).data("peserta");

            $.ajax({
                type: "POST",
                url: url + "/peserta/detail/" + noPeserta,
                data: {
                    _token: csrf_token,
                },
                beforeSend: function () {
                    $("#isLoading").removeClass("display-none");
                },
                success: function (response) {
                    $("#modalDetailPeserta").modal("show");
                    $("#noPeserta").val(response.data.no_peserta);
                    $("#namaPesertaView").val(response.data.nama_peserta);
                    $("#tempatLahirView").val(response.data.tempat_lahir);
                    $("#tanggalLahirView").val(response.data.tanggal_lahir);
                    $("#genderView").val(response.data.gender);
                    $("#namaIbuKandungView").val(
                        response.data.nama_ibu_kandung
                    );
                    $("#alamatView").val(response.data.alamat);
                    $("#kategoriView").val(response.data.kategori);
                },
                complete: function () {
                    $("#isLoading").addClass("display-none");
                },
            });
        });
    };

    return {
        init: function () {
            handleData();
            handlePesertaSave();
            handleDetailData();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
