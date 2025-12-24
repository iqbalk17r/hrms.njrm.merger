<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="container" style="margin-top: 70px;">
    <div class="well text-center">
        <h2>UPDATE WEBSITE</h2>
        <hr>
        <div class="col-md-10 col-md-offset-1">
            <div class="btn btn-warning btn-cek" onclick="updateWeb();" style="margin-bottom: 25px;">Cek Update</div>
            <div class="loader" style="display: none;"></div>
            <div class="msg alert alert-success text-center" style="display: none; font-size: large; margin-bottom: 0;">WEBSITE BERHASIL DI UPDATE !!!</div>
            <div class="msg-info alert alert-info text-center" style="display: none; font-size: large; margin-bottom: 0;"></div>
            <div class="msg-danger alert alert-danger text-center" style="display: none; font-size: large; margin-bottom: 0;"></div>

            <div class="panel panel-default text-left log-box" style="display: none; margin-top: 25px;">
                <div class="panel-heading"><h5 class="text-bold">LOG PERUBAHAN</h5></div>
                <div class="panel-body log-box-body"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    function updateWeb() {
        $('.btn-cek').hide();
        $('.msg').hide();
        $('.msg-info').hide();
        $('.msg-danger').hide();
        $('.log-box').hide();
        $('.loader').show();

        $.ajax({
            type: 'POST',
            url: HOST_URL + "update/exec",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                $('.loader').hide();
                $('.btn-cek').show();

                if (response.status === "true") {
                    $("#loadMe").modal("hide");
                    $('.msg').html("WEBSITE BERHASIL DI UPDATE !!!");
                    $('.msg').show();
                    if(response.logResult != "") {
                        $('.log-box').show();
                        $('.log-box-body').html(response.logResult);
                    }
                } else if (response.status === "false") {
                    var msg = "WEBSITE SUDAH UP-TO-DATE !!";
                    $('.msg-info').html(msg);
                    $('.msg-info').show();
                } else {
                    var msg = "TERJADI KESALAHAN SAAT UPDATE. HUBUNGI TIM IT !!!!!";
                    $('.msg-danger').html(msg);
                    $('.msg-danger').show();
                }
            }
        });
    }
</script>
