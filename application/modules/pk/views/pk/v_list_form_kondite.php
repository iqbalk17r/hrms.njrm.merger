<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    var save_method; //for save method string
    var table;
    $("#example3").dataTable();
    $("#example4").dataTable();
    $(".inputfill").selectize();
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        startView: "year"
    });

    $('input[name=startPeriode], input[name=endPeriode]').change(function() {
        var namaFormulir = $(this).closest('form').attr('name');
        var startPeriodeInput = $('form[name='+namaFormulir+'] input[name=startPeriode]');
        var endPeriodeInput = $('form[name='+namaFormulir+'] input[name=endPeriode]');
        var startDateValue = startPeriodeInput.val();
        var endDateValue = endPeriodeInput.val();
        if (endDateValue < startDateValue) {
            startPeriodeInput.css('border-color', 'red'); 
            endPeriodeInput.css('border-color', 'red'); 
            $('form[name='+namaFormulir+'] #submit').prop('disabled', true); 
        } else {
            startPeriodeInput.css('border-color', ''); 
            endPeriodeInput.css('border-color', '');             
            $('form[name='+namaFormulir+'] #submit').prop('disabled', false);
        }
    });

    var today = new Date();
    var lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
    var currentMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    $('input[name=\'selectedPeriod\']').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        startView: "year",
        startDate: lastMonth,
        endDate: currentMonth
    });
});
</script>
<style>
selectize css .selectize-input {
    overflow: visible;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.selectize-input.dropdown-active {
    min-height: 30px;
    line-height: normal;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.selectize-dropdown,
.selectize-input,
.selectize-input input {
    min-height: 30px;
    line-height: normal;
}

.loading .selectize-dropdown-content:after {
    content: 'loading...';
    height: 30px;
    display: block;
    text-align: center;
}
.ml-3{
    margin-left: 3px;
}
.selectedPeriod{
    background-color: #fff !important;
}
</style>

<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
    <?php if (trim($y1->kodemenu) != trim($kodemenu)) { ?>
    <li><a href="<?php echo site_url(trim($y1->linkmenu)); ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i>
            <?php echo  trim($y1->namamenu); ?></a></li>
    <?php } else { ?>
    <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
    <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message; ?>

<div class="row">
    <div class="col-sm-12">
        <!--div class="container"--->
        <div class="dropdown bg-success">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown"><i class="fa dropdown-active"></i>Menu Input
                <span class="caret"></span></button>
            <ul class="dropdown-menu bg-warning" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"
                        href="#"><i class="fa fa-search"></i>FILTER PENCARIAN</a></li>
                <?php if($userhr): ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal"
                        data-target="#ChoiceOfLetter" href="#"><i class="fa fa-plus"></i>INPUT KONDITE</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Recalculate" href="#"><i class="fa fa-refresh"></i>HITUNG ULANG</a></li>
                <?php endif ?>
            </ul>

        </div>

        <!--/div-->
    </div><!-- /.box-header -->
</div>
</br>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>Dokumen</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>JABATAN</th>
                                    <th>ATASAN 1</th>
                                    <th>ATASAN 2</th>
                                    <th>PERIODE</th>
                                    <th>DEPARTMENT</th>
                                    <th>STATUS</th>

                                    <th width="8%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
								foreach ($list_tx_kondite as $row) : $no++; ?>
                                <tr>
                                    <td width="2%"><?php echo $no; ?></td>
                                    <td><?php echo $row->nodok; ?></td>
                                    <td><?php echo $row->nik; ?></td>
                                    <td><?php echo $row->nmlengkap; ?></td>
                                    <td><?php echo $row->nmjabatan; ?></td>
                                    <td><?php echo $row->nmatasan; ?></td>
                                    <td><?php echo $row->nmatasan2; ?></td>
                                    <td><?php echo $row->periode; ?></td>
                                    <td><?php echo $row->nmdept; ?></td>
                                    <td><?php echo $row->nmstatus; ?></td>
                                    <td width="8%">
                                        <a href="<?php
														$enc_nik = bin2hex($this->encrypt->encode(trim($row->nik)));
														$enc_startperiode = bin2hex($this->encrypt->encode(trim(substr($row->periode, 0, 6))));
														$enc_endperiode = bin2hex($this->encrypt->encode(trim(substr($row->periode, 7, 6))));
														echo site_url("pk/pk/detail_kondite") . '/' . $enc_nik . '/' . $enc_startperiode . '/' . $enc_endperiode; ?>"
                                            class="btn btn-default  btn-sm" title="DETAIL KATEGORI"><i
                                                class="fa fa-bars"></i> </a>
                                        <?php if ((in_array(trim($row->statustx), array('A', 'R1', 'R2')))) { ?>
                                        <a href="<?php
															echo site_url("pk/pk/edit_kondite") . '/' . $enc_nik . '/' . $enc_startperiode . '/' . $enc_endperiode; ?>"
                                            class="btn btn-primary  btn-sm" title="UBAH KONDITE"><i
                                                class="fa fa-gear"></i> </a>

                                        <a href="<?php
															echo site_url("pk/pk/delete_kondite") . '/' . $enc_nik . '/' . $enc_startperiode . '/' . $enc_endperiode; ?>"
                                            class="btn btn-danger  btn-sm" title="HAPUS KONDITE KARYAWAN"><i
                                                class="fa fa-trash-o"></i> </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</div>
<!--/ nav -->



<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> PILIH PERIODE INPUT KONDITE </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/list_nik_from_nik_atasan_kondite') ?>" method="post"
                name="inputPeriode">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-4" for="inputsm">PILIH RENTANG PERIODE NIK</label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">PROSES</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER KONDITE KARYAWAN </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/form_kondite') ?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm inputfill" name="nik" id="nik">
                                                    <option value="">
                                                        <tr>
                                                            <th width="20%">-- NIK |</th>
                                                            <th width="80%">| NAMA KARYAWAN --</th>
                                                        </tr>
                                                    </option>
                                                    <?php foreach ($list_nik as $sc) { ?>
                                                    <option value="<?php echo trim($sc->nik); ?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->nik); ?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmlengkap); ?></th>
                                                        </tr>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">PROSES</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="Recalculate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> Hitung Ulang Kondite Karyawan </h4>
            </div>
            <form class="recalculateConditeee" action="<?php echo site_url('pk/pk/recalculateConditee') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="selectedPeriod" id="selectedPeriod"
                                                               class=" form-control input-sm selectedPeriod" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm " name="selectedEmployee" id="selectedEmployee">
                                                    <option value="">
                                                        <tr>
                                                            <th width="20%">-- NIK |</th>
                                                            <th width="80%">| NAMA KARYAWAN --</th>
                                                        </tr>
                                                    </option>
                                                    <?php foreach ($list_nik as $sc) { ?>
                                                        <option value="<?php echo trim($sc->nik); ?>">
                                                            <tr>
                                                                <th width="20%"><?php echo trim($sc->nik); ?> |</th>
                                                                <th width="80%">| <?php echo trim($sc->nmlengkap); ?></th>
                                                            </tr>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">BATAL</button>
                        <button type="reset" class="btn btn-warning resetRecalculate" >RESET</button>
                        <button type="submit" id="submit" class="btn btn-primary">PROSES</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>



<script>
//Date range picker
$("#tgl").datepicker();
$(".tglan").datepicker();

$(document).ready(function (){
    var $select = $('input[name="selectedEmployee"]').selectize();
    $('#resetButton').click(function() {
        var selectize = $select[0].selectize;
        selectize.clear();
    });
    $('form.recalculateConditeee').on('submit',function (e){
        e.preventDefault();
        Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-sm btn-success ml-3',
                cancelButton: 'btn btn-sm btn-warning ml-3',
                denyButton: 'btn btn-sm btn-danger ml-3',
            },
            buttonsStyling: false,
        }).fire({
            position: 'middle',
            icon: 'question',
            title: 'Apakah anda yakin untuk melakukan hitung ulang ?',
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: `Ya, lanjutkan`,
            showDenyButton: true,
            denyButtonText: `Batal`,
        }).then(function(result) {
            if (result.isConfirmed){
                Swal.fire({
                    title: 'Sedang proses',
                    text: 'Harap tunggu sampai proses selesai',
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false
                });
                $.ajax({
                    url: $('form.recalculateConditeee').attr('action'),
                    data: $('form.recalculateConditeee').serialize(),
                    type: 'POST',
                    success: function (data) {
                        Swal.close();
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm ml-3',
                                cancelButton: 'btn btn-sm ml-3',
                                denyButton: 'btn btn-sm ml-3',
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
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function() { });
                    },
                    error: function (xhr, status, thrown) {
                        Swal.close();
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
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function(){ });
                    },
                });
            }
        });
    })
})
</script>