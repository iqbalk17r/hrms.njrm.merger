<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/14/19 12:23 PM
 *  * Last Modified: 5/14/19 12:23 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"--->
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script--->
<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script--->
<!--<script type="text/javascript">
    function _(el) {
        return document.getElementById(el);
    }

    function uploadFile() {
        $("#prosesx").attr("disabled", true).text("Checking Data");

        var filename = $("#file1").val();
        var extension = filename.replace(/^.*\./,".");
        if (extension === filename) {
            extension = '.';
        } else {
            extension = extension.toLowerCase();
        }

        if (extension!==".zip"){
            alert("Extensi Tidak Sesuai , Harap melampirkan extensi yang sesuai !!!");
            $("#prosesx").attr("disabled", false).text("Proses");

        } else {
            /* start upload */
            var file = _("file1").files[0];
            // alert(file.name+" | "+file.size+" | "+file.type);
            var formdata = new FormData();
            formdata.append("file1", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "<?php /*echo site_url('payroll/import/post_import_data'); */?>");
            //use file_upload_parser.php from above url
            ajax.send(formdata);
            $("#prosesx").attr("disabled", false).text("Proses");
            console.log('SUBMIT');
        }
    }

    function progressHandler(event) {
        _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
    }

    function completeHandler(event) {
        _("status").innerHTML = event.target.responseText;
        _("progressBar").value = 0; //wil clear progress bar after successful upload
        $("#prosesx").attr("disabled", false).text("Checking Data");
    }

    function errorHandler(event) {
        _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event) {
        _("status").innerHTML = "Upload Aborted";
    }
    /* end upload progress */
    $(".modal").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false //remove option to close with keyboard
    });

</script>-->
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message;?>

<!--<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">
                </div>
            </div>
            <div class="box-body" style='overflow-x:scroll;'>
                <form  method="post" enctype="multipart/form-data" id="upload_form" action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="form-group ">
                                                <input type="file" name="file1" id="file1"  class="form-control "  >
                                                <progress id="progressBar" value="0" max="100" style="width:100%;height: 10%; "></progress>
                                                <h3 id="status"></h3>
                                                <p id="loaded_n_total"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="uploadFile()" id="prosesx" class="btn btn-primary">PROSES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->

<div class="container" style="margin-top:0px;">
    <div class="well text-center">
        <h2>Upload Data Anda Di Sini</h2>
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <form class="form-inline" method="post" action="#" enctype="multipart/form-data" >
                <div class="input-group">
                    <label class="input-group-btn">
							<span class="btn btn-danger btn-lg">
								Browse&hellip; <input type="file" id="media" name="media" style="display: none;" required>
							</span>
                    </label>
                    <input type="text" class="form-control input-lg" size="40" readonly required>
                </div>
                <div class="input-group">
                    <input type="submit" class="btn btn-lg btn-primary" value="Start upload">
                </div>
            </form>
            <br>
            <p id="loaded_n_total"></p>
            <div class="progress" style="display:none">

                <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only">0%</span>
                </div>

            </div>
            <div class="msg alert alert-info text-left" style="display:none">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        function _(el) {
            return document.getElementById(el);
        }
        function progressHandler(event) {
            _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
        }

        $('form').on('submit', function(event){
            event.preventDefault();
            //var formData = new FormData($('form')[0]);
            //var file = _("media").files[0];
            var file = $('#media')[0].files[0];
            var formdata = new FormData();
            formdata.append("media", file);

            $('.msg').hide();
            $('.progress').show();

            var filename = $("#media").val();
            var extension = filename.replace(/^.*\./,".");
            if (extension === filename) {
                extension = '.';
            } else {
                extension = extension.toLowerCase();
            }

            if (extension!==".zip"){
                alert("Extensi Tidak Sesuai , Harap melampirkan extensi yang sesuai !!!");
            } else {
                //progresnya
                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                console.log('Bytes Loaded : ' + e.loaded);
                                console.log('Total Size : ' + e.total);
                                console.log('Persen : ' + (e.loaded / e.total));

                                var percent = Math.round((e.loaded / e.total) * 100);

                                $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
                                $('#loaded_n_total').text("Uploaded " + e.loaded + " bytes of " + e.total);
                            }
                        });
                        return xhr;
                    },

                    type: 'POST',
                    url: "<?php echo site_url('payroll/import/post_import_data'); ?>",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('form')[0].reset();
                        $('.progress').hide();
                        $('.msg').show();
                        console.log(response);
                        if (response == "") {
                            console.log(formdata.status);
                            alert(formdata.show);
                        } else {
                            if(response.status==='true'){
                                $("#loadMe").modal({
                                    backdrop: "static", //remove ability to close modal with click
                                    keyboard: false, //remove option to close with keyboard
                                    show: true //Display loader!
                                });
                                //ajax progress here progress replicate data

                                $.ajax({
                                    type: 'POST',
                                    url: "<?php echo site_url('payroll/import/i_csv_mstkaryawan_all'); ?>",
                                    dataType: "json",
                                    async:false,
                                    success: function (data) {
                                        if (data.status = true) {
                                            console.log(data.status);
                                            $("#loadMe").modal("hide");
                                            var msg = 'File berhasil di upload. ID file = ' + response.show;
                                            $('.msg').html(msg);
                                        } else {
                                            //end ajax here
                                            console.log(data.status);
                                            $("#loadMe").modal("hide");
                                            var msg = 'File Dan Data Gagal Di Proses!!!, Pastikan Data Benar!!';
                                            $('.msg').html(msg);
                                        }
                                    } ,
                                    error: function (textStatus, errorThrown) {
                                        $("#loadMe").modal("hide");
                                        var msg = 'File Dan Data Gagal Di Proses!!!, Pastikan Data Benar!!';
                                        $('.msg').html(msg);
                                    }
                                });
                                // console.log(response.status);
                                // var msg = 'File berhasil di upload. ID file = ' + response.show;
                                // $('.msg').html(msg);
                                //end ajax here

                            } else {
                                var msg = 'File Gagal Di Upload';
                                $('.msg').html(msg);
                            }

                        }
                    }
                });
            }
        });
    });

    $(function() {
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });

    });


</script>