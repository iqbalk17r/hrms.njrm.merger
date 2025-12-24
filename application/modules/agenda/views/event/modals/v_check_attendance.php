<style>
    input.largerCheckbox {
        margin-top: 0px;
        width: 23px;
        height: 23px;
    }
</style>
<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <div class="col-sm-12 table-responsive participant">
                    <?php
                    echo $participant['generatetable'];
                    echo $participant['jquery'];
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div>
        <div class="modal-footer">
            <div class="btn-toolbar">
                <button type="button" class="btn btn-warning pull-left close-modal" >Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('button.close-modal').on('click',function(){
            $('div#modal-event').modal('hide');
            $('div#modal-event').on('hidden.bs.modal', function () {
                $(this).removeClass('fade').modal('hide'); // Reset modal
                $('.modal-backdrop').remove(); // Remove any remaining backdrop
                $(this).find('.modal-content').html(''); // Optional: clear modal content
            });
        });
        $('table#table-participant').on('click','button.empty', function(){
            var row = $(this)
            $.ajax({
                url: row.data('href'),
                type: 'POST',
                success: function (data) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Berhasil',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                        $('table#table-participant').DataTable().draw(false);
                    });
                },
                error: function (xhr, status, thrown) {
                    console.log(xhr)
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                },
            });
        });
        $('table#table-participant').on('click','button.join', function(){
            var row = $(this)
            $.ajax({
                url: row.data('href'),
                type: 'POST',
                success: function (data) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Berhasil',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                        $('table#table-participant').DataTable().draw(false);
                    });
                },
                error: function (xhr, status, thrown) {
                    console.log(xhr)
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                },
            });
        });
        $('table#table-participant').on('click','button.leave', function(){
            var row = $(this)
            $.ajax({
                url: row.data('href'),
                type: 'POST',
                success: function (data) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Berhasil',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                        $('table#table-participant').DataTable().draw(false);
                    });
                },
                error: function (xhr, status, thrown) {
                    console.log(xhr)
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                },
            });
        });
    })
</script>
