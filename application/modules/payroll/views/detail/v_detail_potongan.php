<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/7/19 2:35 PM
 *  * Last Modified: 6/11/16 10:24 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

/*
	@author : junis 10-12-2012\m/
*/
?>
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
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php //echo '<h3>NIK : '.$nik.'<br>';?>
			<?php //echo 'Nama : '.$nama.'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("payroll/detail_payroll/detail/$enc_nik/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja");?>" class="btn btn-default" style="margin:0px; color:#000000;">Kembali</a>

                    <form action="<?php echo site_url('payroll/detail_payroll/ubah_pinjaman')?>" method="post">
                            <input type="hidden" id="type" name="type"  value="RESET" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                            <input type="hidden" id="docref" name="docref"  value="<?php echo trim($nodok);?>" class="form-control">
                            <input type="hidden" id="nik" name="nik"  value="<?php echo trim($nik);?>" class="form-control">
                            <input type="hidden" id="no_urut" name="no_urut"  value="<?php echo trim($no_urut);?>" class="form-control">
                            <input type="hidden" id="kdgroup_pg" name="kdgroup_pg"  value="<?php echo trim($kdgroup_pg);?>" class="form-control">
                            <input type="hidden" id="kddept" name="kddept"  value="<?php echo trim($kddept);?>" class="form-control">
                            <input type="hidden" id="periode" name="periode"  value="<?php echo trim($periode);?>" class="form-control">
                            <input type="hidden" id="keluarkerja" name="keluarkerja"  value="<?php echo trim($keluarkerja);?>" class="form-control">
                            <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> Tarik </button>
                    </form>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No. Dokumen</th>								
							<th>NIK</th>								
							<th>NAMA LENGKAP</th>
							<th>Tanggal</th>
							<th>Nominal</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($detail_potongan as $lu) {;?>
						<tr>										
							<td><?php echo $lu->docno;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->tgl;?></td>
							<td align="right"><?php echo number_format($lu->out_sld, 2);?></td>
							<td>
								<a href="#" data-toggle="modal" data-target="#ubah<?php echo trim($lu->docno); ?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-gear"></i> Ubah
								</a>
                                <a href="#" data-toggle="modal" data-target="#hapus<?php echo trim($lu->docno); ?>" class="btn btn-danger  btn-sm">
                                    <i class="fa fa-edit"></i> Hapus
                                </a>
							</td>
						</tr>
						<?php };?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!-- modal edit data -->
<?php foreach ($detail_potongan as $lu) { ?>
<div class="modal fade" id="ubah<?php echo trim($lu->docno); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Detail Potongan Pinjaman Payroll</h4>
      </div>
	  <form action="<?php echo site_url('payroll/detail_payroll/ubah_pinjaman')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						
							<div class="form-group">
								<label class="col-sm-4">Nama Komponen</label>	
								<div class="col-sm-8">
                                    <input type="hidden" id="type" name="type"  value="EDIT" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($lu->docref);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
									<input type="hidden" id="tgl" name="tgl"  value="<?php echo trim($lu->tgl);?>" class="form-control" style="text-transform:uppercase" maxlength="50" >
									<input type="text" id="docno" name="docno"  value="<?php echo trim($lu->docno);?>" class="form-control" readonly>
									<input type="hidden" id="nik" name="nik"  value="<?php echo trim($lu->nik);?>" class="form-control">
									<input type="hidden" id="no_urut" name="no_urut"  value="<?php echo trim($no_urut);?>" class="form-control">
									<input type="hidden" id="kdgroup_pg" name="kdgroup_pg"  value="<?php echo trim($kdgroup_pg);?>" class="form-control">
									<input type="hidden" id="kddept" name="kddept"  value="<?php echo trim($kddept);?>" class="form-control">
									<input type="hidden" id="periode" name="periode"  value="<?php echo trim($periode);?>" class="form-control">
									<input type="hidden" id="keluarkerja" name="keluarkerja"  value="<?php echo trim($keluarkerja);?>" class="form-control">
									
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									
									<input type="hidden" id="old_nominal" name="old_nominal"  value="<?php echo trim(round($lu->out_sld));?>"  class="form-control ratakanan"   >
									<input type="text" id="nominal" name="nominal"  value="<?php echo trim(round($lu->out_sld));?>"  class="form-control ratakanan"   >

									
								</div>
							</div>
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<!--<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">

							
							
						</div>													
					</div>												
				</div>	
			</div>-->	
		</div>	
	</div>	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>



<!-- modal edit data -->
<?php foreach ($detail_potongan as $lu) { ?>
    <div class="modal fade" id="hapus<?php echo trim($lu->docno); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Detail Potongan Pinjaman Payroll</h4>
                </div>
                <form action="<?php echo site_url('payroll/detail_payroll/ubah_pinjaman')?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">

                                            <div class="form-group">
                                                <label class="col-sm-4">Nama Komponen</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="type" name="type"  value="DELETE" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                                                    <input type="hidden" id="docref" name="docref"  value="<?php echo trim($lu->docref);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                                                    <input type="hidden" id="tgl" name="tgl"  value="<?php echo trim($lu->tgl);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                                                    <input type="text" id="docno" name="docno"  value="<?php echo trim($lu->docno);?>" class="form-control" readonly>
                                                    <input type="hidden" id="nik" name="nik"  value="<?php echo trim($lu->nik);?>" class="form-control">
                                                    <input type="hidden" id="no_urut" name="no_urut"  value="<?php echo trim($no_urut);?>" class="form-control">
                                                    <input type="hidden" id="kdgroup_pg" name="kdgroup_pg"  value="<?php echo trim($kdgroup_pg);?>" class="form-control">
                                                    <input type="hidden" id="kddept" name="kddept"  value="<?php echo trim($kddept);?>" class="form-control">
                                                    <input type="hidden" id="periode" name="periode"  value="<?php echo trim($periode);?>" class="form-control">
                                                    <input type="hidden" id="keluarkerja" name="keluarkerja"  value="<?php echo trim($keluarkerja);?>" class="form-control">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4">Nominal</label>
                                                <div class="col-sm-8">

                                                    <input type="text" id="nominal" name="nominal"  value="<?php echo trim(round($lu->out_sld));?>"  class="form-control ratakanan"  readonly >


                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                            <!--<div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">



                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">HAPUS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>




