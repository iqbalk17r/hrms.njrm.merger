<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(function() {
        var table = $("#table").DataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0]
            }],
        });
        table.on("order.dt search.dt", function() {
            table.column(0, {
                search: "applied", order: "applied"
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    function add_person()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tarik Data Absen'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
        save_method = 'update';

        $('#editform')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('trans/absensi/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="kdkepegawaian"]').val(data.kdkepegawaian);
                $('[name="nmkepegawaian"]').val(data.nmkepegawaian);
                // show bootstrap modal when complete loaded
                $('#modal_form').modal('hide');
                $('#edit_form').modal('show');
                $('.modal-title').text('Edit Status Kepegawaian'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function save()
    {
        $('#btnSave').text('Memproses....!!');
        $('#btnSave').attr('disabled',true);
        var url;
        if(save_method == 'add')
        {
            url = "<?php echo site_url('trans/absensi/tarik_data_mobile')?>";
            data = $('#form').serialize();
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            //data: $('#form').serialize(),
            data: data,
            dataType: "JSON",
            success: function(data)
            {
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                $('#edit_form').modal('hide');
                //reload_table();
                $('#message').show();
                $("#message").html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b>Data Sukses Di simpan</b> </div>");
                setTimeout(function() {
                    $("#message").hide('blind', {}, 500)
                }, 5000);
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#modal_form').modal('hide');
                alert('Error Memproses data');
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled',false);
            }
        });
    }

    function delete_person(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('trans/absensi/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                    $("#message").html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b> Hapus Data Sukses</b></div>");
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');

                }
            });

        }
    }

</script>
<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th:first-child {
        padding-right: 8px !important;
        width: 1%;
    }
</style>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div id="message" >
</div>
<div><?php echo 'Total data: '.$ttldata; ?></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">
                    <!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Negara</a>-->
                    <a href="<?php echo site_url('trans/absensi/filter_absen_mobile');?>" class="btn btn-default" style="margin:10px; color:#000000;"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button class="btn btn-success" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="fa fa-plus"></i> Data Mesin Absen</button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>User ID</th>
                        <th>Badgenumber</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Checktime</th>
                        <?php if($maplikasi == "MCRM"): ?>
                            <th>Kode Customer</th>
                            <th>Customer NOO</th>
                            <th>Nama Customer</th>
                            <th>Tipe Customer</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list_absen as $v): ?>
                        <tr>
                            <td class="text-nowrap text-center"></td>
                            <td class="text-nowrap"><?= $v->userid ?></td>
                            <td class="text-nowrap"><?= $v->idabsen ?></td>
                            <td class="text-nowrap"><?= $v->nik ?></td>
                            <td><?= $v->usersname ?></td>
                            <td class="text-nowrap"><?= $v->checktime ?></td>
                            <?php if($maplikasi == "MCRM"): ?>
                                <td class="text-nowrap"><?= $v->customeroutletcode ?></td>
                                <td class="text-nowrap"><?= $v->customercodelocal ?></td>
                                <td><?= $v->custname ?></td>
                                <td class="text-nowrap"><?php
                                    switch($v->customertype) {
                                        case "A":
                                            echo "KANTOR";
                                            break;
                                        case "B":
                                            echo "BANK";
                                            break;
                                        case "C":
                                            echo "CUSTOMER/TOKO";
                                            break;
                                        default:
                                            echo "BELUM TERDEFINISI";
                                    }
                                ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tarik Data</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="tgl1" value="<?php echo $tgl1;?>" readonly />
                    <input type="hidden" name="tgl2" value="<?php echo $tgl2;?>" readonly />
                    <input type="hidden" name="kdcabang" value="<?php echo $kdcabang;?>"  readonly/>
                    <input type="hidden" name="maplikasi" value="<?php echo $maplikasi;?>"  readonly/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="edit_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Kode kepegawaiantype</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="editform" class="form-horizontal">
                    <!--<input type="hidden" value="" name="id"/> -->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Status Kepegawaian</label>
                            <div class="col-md-9">
                                <input name="kdkepegawaian" placeholder="Kode kepegawaiantype" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status Kepegawaian</label>
                            <div class="col-md-9">
                                <input name="nmkepegawaian" placeholder="Jenis kepegawaiantype" style="text-transform:uppercase;" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
