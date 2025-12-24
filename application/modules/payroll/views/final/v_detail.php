<?php 
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
<?php echo '<h3>NIK : '.$nik.'<br>';?>
			<?php echo 'Nama : '.$nama.'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					
					
					<a href="<?php echo site_url("payroll/final_payroll/master/$nodok");?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;"><i class="fa fa-arrow-left"></i> Kembali</a>
					<a href="<?php echo site_url("payroll/final_payroll/excel_payroll_detail/$nik/$nodok")?>"  class="btn btn-default" style="margin:10px;"><i class="fa fa-download"></i> Download Excel</a>
					<?php /* <a href="<?php echo site_url("payroll/final_payroll/download_pdf/$nik/$nodok")?>"  class="btn btn-danger" style="margin:10px;">Download Slip</a> */ ?>
					<a href="<?php
                    $enc_nodok = $this->fiky_encryption->enkript($nodok);
                    $enc_nik = $this->fiky_encryption->enkript($nik);
                    echo site_url("payroll/final_payroll/cetakSlipGaji/$enc_nodok/$enc_nik")?>"  class="btn btn-danger" style="margin:10px;"><i class="fa fa-print"></i> Cetak Slip</a>

                    <a href="#" data-toggle="modal" data-target="#modalFormSlip" class="btn btn-warning" style="margin:10px; color:#000000;"><i class="fa fa-envelope-o"></i> Kirim Email SLip Gaji </a>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="crut" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nama Komponen</th>
							<th>Keterangan</th>	
							<th>Nominal (Rp.)</th>								
													
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_detail as $lu) {;?>
						<tr>										
							<td width="2%"><?php echo $lu->no_urut;?></td>																							
							<td><?php echo $lu->keterangan;?></td>
							<td><?php echo $lu->uraian;?></td>
							<td align="right"><?php echo $lu->nominal1;?></td>
						</tr>
						<?php };?>
					</tbody>
					<tfoot>
						<tr>
							<td class="right" colspan="3">Total Upah:</td><td align="right"><?php echo $total_upah;?></td> 
						</tr>
					</tfoot>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<div class="modal fade" id="modalFormSlip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Kirim Email Slip Gaji</h4>
            </div>
            <div class="modal-body form">
            <form action="#" id="formSlip" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4">Nik</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($nodok);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                                                <input type="text" id="nik" name="nik"  value="<?php echo trim($nik);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Nama Karyawan</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nmlengkap" name="nmlengkap"  value="<?php echo trim($dtl_karyawan['nmlengkap']);?>" class="form-control" style="text-transform:uppercase" maxlength="100"readonly >
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Email</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="email" name="email"  value="<?php echo strtolower(trim($dtl_karyawan['email']));?>" class="form-control" style="text-transform:uppercase" maxlength="50" required readonly>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-warning"><i class="fa fa-envelope"></i> Kirim Email</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

    var save_method; //for save method string
    var table;

    function save()
    {
        save_method = 'add';
       /* var validator = $('#formSlip').data('bootstrapValidator');
        validator.validate();
        if (validator.isValid()) {*/
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable
            var url;

            if (save_method == 'add') {
                url = "<?php echo site_url('payroll/final_payroll/gxpfxoek_x1_roll')?>";
            }

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formSlip').serialize(),
                dataType: "JSON",
                success: function (data) {

                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#modalFormSlip').modal('hide');
                        //reload_table();
                    }

                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Gagal Cek Email Pada Master Karyawan/ Konfigurasi Email Salah');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable

                }
            });
       // }
    }


</script>

