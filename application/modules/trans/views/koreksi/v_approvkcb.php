<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$(".tgl").datepicker();
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();
				//$("#nik1").selectize();

                $('.fgr').hide();
                $('#doctype').on('change', function(){
                    if ($(this).val()=='Y') {
                        $('.fgr').show();
                        $('.fgr1').hide();
                    } else {
                        $('.fgr').hide();
                        $('.fgr1').show();
                    }

                });
            });
		
</script>

<legend><?php echo $title;?></legend>

<a href="<?php echo site_url('trans/koreksi');?>" type="button" class="btn btn-default"/> Kembali</a>
<form action="<?php echo site_url('trans/koreksi/savekcb')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
                            <input value='APPROVAL' name='type' type="hidden"  class="form-control" >

                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Mulai</label>
                                <div class="col-sm-8">
                                    <input value='<?php echo $dtl['nodok'];?>' name='nodok' type="text"  class="form-control" readonly>
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-4">INPUT NIK KARYAWAN</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="nik" id="nik1" disabled>
									<option value="">--Cari Nama Karyawan--</option>
									<?php foreach ($list_karyawan as $lk) { ?>
									<option <?php if (trim($lk->nik)==trim($dtl['nik'])) { echo 'selected';}?>  value="<?php echo trim($lk->nik); ?>"><?php echo trim($lk->nmlengkap).' || '.trim($lk->nik); ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-4">PILIH TYPE KOREKSI</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="doctype" id="doctype" disabled>
                                        <option value="">--Pilih Type Koreksi--</option>
                                        <?php foreach ($lTypeKoreksi as $lk) { ?>
                                            <option <?php if (trim($lk->kdtrx)==trim($dtl['doctype'])) { echo 'selected';}?>  value="<?php echo trim($lk->kdtrx); ?>"><?php echo trim($lk->uraian); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group fgr">
								<label class="col-sm-4">DOKUMEN CUTI BERSAMA</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm" name="docref" id="docref1" disabled>
									<option value="">--Cari Nomor Dokumen--</option>
									<?php foreach ($listcb as $lcb) { ?>
									<option <?php if (trim($lcb->kdtrx)==trim($dtl['docref'])) { echo 'selected';}?>  value="<?php echo trim($lcb->nodok);?>" class="<?php echo trim($lcb->nodok);?>"><?php echo trim($lcb->nodok);?></option>
									<?php } ?>
									</select>
									
								</div>
							</div>	

							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl_awal" name="tgl_awal" data-date-format="dd-mm-yyyy"   value="<?php echo date('d-m-Y', strtotime(trim($dtl['tgl_awal'])));?>" class="form-control tgl" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl_akhir" name="tgl_akhir" data-date-format="dd-mm-yyyy"  value="<?php echo date('d-m-Y', strtotime(trim($dtl['tgl_akhir'])));?>" class="form-control tgl" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti</label>	
								<div class="col-sm-8">    
									<input align="right" type="text"  class="form-control"  value="<?php echo trim($dtl['jumlahcuti']);?>" disabled>
								</div>	
							</div>
                            <div class="form-group">
                                <label class="col-sm-4">PILIH TYPE OPERATOR</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="operator" id="operator" disabled>
                                        <?php foreach ($lTypeOperator as $lk) { ?>
                                            <option <?php if (trim($lk->kdtrx)==trim($dtl['operator'])) { echo 'selected';}?> value="<?php echo trim($lk->kdtrx); ?>"><?php echo trim($lk->uraian); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan" style="text-transform:uppercase" class="form-control" disabled><?php echo trim($dtl['keterangan']);?></textarea>
								</div>
							</div>		
						</div>
					</div>													
				</div>
			</div>
		</div>
	</div>
	<div>

        <button type="submit"  class="btn btn-success"> Approval </button>
    </div>
</form>
