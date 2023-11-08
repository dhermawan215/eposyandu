var Index = (function () {
    const csrf_token = $('meta[name="csrf-token"]').attr("content");

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
                    console.log(response);
                },
                error: function (response) {
                    console.log(response);
                },
            });
        });
    };

    return {
        init: function () {
            handleKategoriSave();
            console.log(url);
            console.log("ready to jquery");
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
