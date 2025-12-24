<?php 
/*
	@author : Fiky Ashariza 07/01/2017
*/

?>

<style>
.space {
    margin: 2px;
}
</style>

<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    $("#example2").dataTable();
    $("#example3").dataTable();
    $("#dateinput").datepicker();
    $("#dateinput1").datepicker();
    $("#dateinput2").datepicker();
    $("#dateinput3").datepicker();
    $("[data-mask]").inputmask();
});
</script>
<script>
$(document).ready(function() {
    function disableBack() {
        window.history.forward()
    }
    window.onload = disableBack();
    window.onpageshow = function(evt) {
        if (evt.persisted) disableBack()
    }
});
</script>
<?php echo $message;?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
        <div class="col-sm-12">
            <?php if ($akses['aksesinput'] == 't') { ?>
            <a href="<?php echo site_url("trans/dinas/create")?>"
                class="btn btn-success ml-3 pull-right space">Input</a>
            <?php } ?>
            <a href="#" data-toggle="modal" data-target="#filter"
                class="btn btn-primary ml-3 pull-right space">Filter</a>
        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12 table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomer Dokumen</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Department</th>
                        <th>Keperluan</th>
                        <th>Tujuan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0; foreach($list_dinas as $lu): $no++;?>
                    <tr>
                        <td width="2%"><?php echo $no;?></td>
                        <td><?php echo $lu->nodok;?></td>
                        <td><?php echo $lu->nik;?></td>
                        <td><?php echo $lu->nmlengkap;?></td>
                        <td><?php echo $lu->nmdept;?></td>
                        <td><?php echo $lu->keperluan;?></td>
                        <td><?php echo $lu->namakotakab;?></td>
                        <td><?php echo $lu->tgl_mulai;?></td>
                        <td><?php echo $lu->tgl_selesai;?></td>
                        <td><?php echo $lu->status1;?></td>
                        <td>
                            <?php if (trim($lu->nik)!=trim($nama) or trim($lu->status)=='P' or trim($lu->status)=='D' or trim($lu->status)=='C') { ?>
                            <a <?php $nodok=trim($lu->nodok);?>
                                href="<?php echo site_url("trans/dinas/detaildinas/".bin2hex(json_encode(array('nik' => trim($lu->nik), 'nodok' => trim($nodok), ))));?>"
                                class="btn btn-success btn-sm m-1 space">
                                <i class="fa fa-edit"></i> Detail
                            </a>
                            <?php } ?>
                            <?php if ((trim($lu->status)=='P' AND (date('Y-m-d') >= $lu->tgl_mulai AND date('Y-m-d') <= $lu->tgl_selesai) ) AND ($userhr>0 OR trim($this->session->userdata('nik')) == trim($lu->nik) OR $level_akses == 'A' )) { ?>
                                <a <?php $nodok=trim($lu->nodok);?>
                                        href="<?php echo site_url("trans/dinas/updatedinas/".bin2hex(json_encode(array('nik' => trim($lu->nik), 'nodok' => trim($nodok), 'config'=>'extend' ))));?>"
                                        onclick="return confirm('Anda Yakin Edit Data ini?')"
                                        class="btn btn-danger  btn-sm m-1 space">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            <?php } ?>
                            <?php if (trim($lu->status)=='P') { ?>
                            <button class="button btn btn-warning  btn-sm space" onClick="window.open('<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                    echo site_url("trans/dinas/cetak_tok".'/'.$enc_nodok);?>');" title="Cetak Dinas"><i
                                    class="fa fa-print"></i></button>
                            <?php } ?>
                            <?php if (trim($lu->status)<>'C' and trim($lu->status)<>'D' AND $lu->casboned != 't' AND $lu->declared != 't' ) {?>
                            <?php if ($akses['aksesupdate']=='t' AND $userhr>0 ) { ?>
                            <a <?php $nodok=trim($lu->nodok);?>
                                href="<?php echo site_url("trans/dinas/updatedinas/".bin2hex(json_encode(array('nik' => trim($lu->nik), 'nodok' => trim($nodok), ))));?>"
                                onclick="return confirm('Anda Yakin Edit Data ini?')"
                                class="btn btn-default  btn-sm m-1 space">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php }else if ($akses['aksesupdate']=='t' and trim($lu->status)<>'P' AND ($lu->history_approve < 1) )  { ?>
                            <a <?php $nodok=trim($lu->nodok);?>
                                href="<?php echo site_url("trans/dinas/updatedinas/".bin2hex(json_encode(array('nik' => trim($lu->nik), 'nodok' => trim($nodok), ))));?>"
                                onclick="return confirm('Anda Yakin Edit Data ini?')"
                                class="btn btn-default  btn-sm m-1 space">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($akses['aksesdelete']=='t' and trim($lu->status)<>'P' AND $lu->history_approve < 1 )  { ?>
                            <a href="<?php $nodok=trim($lu->nodok); echo site_url("trans/dinas/hapus/$nodok")?>"
                                onclick="return confirm('Anda Yakin Batalkan Data ini?')"
                                class="btn btn-danger  btn-sm m-1 space">
                                <i class="fa fa-trash-o"></i> Batalkan
                            </a>
                            <?php } ?>


                            <?php } ?>

                            <?php if($akses['aksesdelete']=='t' and $userhr>0 and trim($lu->status)=='P') { ?>
                            <a href="<?php $nodok=trim($lu->nodok); echo site_url("trans/dinas/hapus/$nodok")?>"
                                onclick="return confirm('Anda Yakin Batalkan Data ini?')"
                                class="btn btn-danger  btn-sm m-1 space">
                                <i class="fa fa-trash-o"></i> Batalkan
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Periode DINAS Karyawan</h4>
            </div>
            <form action="<?php echo site_url('trans/dinas/index')?>" method="post">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Bulan</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name='bulan'>

                                <option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari
                                </option>
                                <option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari
                                </option>
                                <option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret
                                </option>
                                <option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April
                                </option>
                                <option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
                                <option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni
                                </option>
                                <option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli
                                </option>
                                <option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus
                                </option>
                                <option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September
                                </option>
                                <option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober
                                </option>
                                <option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November
                                </option>
                                <option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Tahun</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="tahun">
                                <option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?>
                                </option>
                                <option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'>
                                    <?php $tgl=date('Y')-1; echo $tgl; ?></option>
                                <option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'>
                                    <?php $tgl=date('Y')-2; echo $tgl; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="status">
                                <option value="">SEMUA</option>
                                <option value="P">DISETUJUI</option>
                                <option value="A">PERLU PERSETUJUAN</option>
                                <option value="C">DIBATALKAN</option>
                                <option value="D">DIHAPUS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit1" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>