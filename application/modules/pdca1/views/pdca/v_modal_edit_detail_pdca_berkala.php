<?php 
/*
	@author : fiky 10-12-2017
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $(".grid").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();

			});				
</script>



        <div class="modal-dialog modal-sm-12">
            <div class="modal-content">

			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	
			<legend><?php echo $title;?></legend>
			<h5><?php echo $title2;?></h5>
			<!--?php echo $message;?-->
			
			<!--h4 class="modal-title" id="myModalLabel">Transaksi Bulan</h4--->
			</div>
					<form action="<?php echo site_url('pdca/pdca/save_edit_pdca_brk')?>" method="post" name="inputformPbk">
					<div class="modal-body">										
						<div class="row">
						<div class="col-sm-12">
						<div class="box box-danger">
						<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="nomor" id="nomor" value="<?php echo trim($nomor); ?>" class="form-control "  readonly>
										<input type="hidden" name="planperiod" id="planperiod" value="<?php echo trim($planperiod); ?>" class="form-control "  readonly>
										<input type="hidden" name="urutcategory" id="urutcategory" value="<?php echo trim($urutcategory); ?>" class="form-control "  readonly>
										<input type="hidden" name="dy" id="dy" value="<?php echo trim($dy); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="EDIT_CATEGORY_DATE" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DESKRIPSI PLAN </label>	
									<div class="col-sm-8"> 
										<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($dtl_gen['descplan']); ?></textarea>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4"><?php echo trim($dtl_gen['category']);?></label>	
								<div class="col-sm-8"> 
									<?php if(trim($dtl_gen['nomor'])!='999' and trim($dtl_gen['urutcategory'])=='3') { ?>
										<input type="number" id="category_date" name="category_date" min="0" max="100" value="<?php echo trim($category_date);?>" class="form-control"   required>
									<?php } else if(trim($dtl_gen['nomor'])=='999' and trim($dtl_gen['urutcategory'])=='10' and $nama==trim($dtl_gen['nik_atasan'])) { ?>	
										<select class="form-control input-sm " name="category_date" required>
										<option value="INPUT"> INPUT </option> 
										<option value="FINAL"> FINAL DISETUJUI </option> 
										</select>
									<?php } else if(trim($dtl_gen['nomor'])=='999' and trim($dtl_gen['urutcategory'])=='10' and $nama!=trim($dtl_gen['nik_atasan'])) { ?>	
										<select class="form-control input-sm " name="category_date" disabled>
										<option value="INPUT"> INPUT </option> 
										<option value="FINAL"> FINAL DISETUJUI </option> 
										</select>	
									<?php } else if (in_array(trim($dtl_gen['urutcategory']), array('1', '2', '3')) and trim($dtl_gen['nomor'])=='999') { ?>	
										<input type="input" name="category_date" id="category_date" value="<?php echo trim($category_date); ?>" class="form-control " <?php if (trim($dy)!='XX') { ?> maxlength="14" <?php } ?>  style="text-transform:uppercase" readonly>
									<?php } else { ?>
										<input type="input" name="category_date" id="category_date" value="<?php echo trim($category_date); ?>" class="form-control " <?php if (trim($dy)!='XX') { ?> maxlength="14" <?php } ?>  style="text-transform:uppercase" required>
									<?php } ?>
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
					<?php if (in_array(trim($dtl_gen['urutcategory']), array('1', '2', '3')) and trim($dtl_gen['nomor'])=='999' and $nama!=trim($dtl_gen['nik_atasan'])) { ?>	
					<button type="submit" id="submit"  class="btn btn-primary" disabled>SIMPAN</button>
					<?php } else if(trim($dtl_gen['nomor'])=='999' and trim($dtl_gen['urutcategory'])=='10' and $nama!=trim($dtl_gen['nik_atasan'])) { ?>	
					<button type="submit" id="submit"  class="btn btn-primary" disabled>SIMPAN</button>
					<?php } else if(trim($dtl_gen['nomor'])=='999' and trim($dtl_gen['urutcategory'])!='10' and $nama=trim($dtl_gen['nik_atasan'])) { ?>	
					<button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
					<?php } else { ?>
					<button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
					<?php } ?>
				  </div>
				  </form>
        </div>
    </div>

<!--Modal Data Detail -->

    <div  class="modal fade pp1" data-modal-parent=".pp" data-backdrop-limit="1" >
                <!-- Content will be loaded here from "remote.php" file -->
    </div>

<!---End Modal Data --->
