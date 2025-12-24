<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
			//disabel enable selection
			function disableSelects(form){
			for(var i=0;i<form.elements.length;i++){
			  if(form.elements[i].type.match(/select/i)){
				 form.elements[i].disabled = 1;
			  }
			  if(form.elements[i].type.match(/checkbox/i)){
				 form.elements[i].onclick = function(){
				 this.parentNode.getElementsByTagName('select')[0].disabled =
				 this.parentNode.getElementsByTagName('select')[0].disabled == 0 ? 1 : 0; 
				}
			  }
			}
		  }
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
                        <div class="col-xs-12">  
						<a href="<?php echo site_url('hrd/report');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-search"></i><font color="#fffff"><b>FILTER</b></font></a>                                
						<!--<p align='right' style='margin-right:10px'>Download Laporan Turn Over:
						<a href="<?php echo site_url('hrd/report/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a>
						<a href="<?php echo site_url('hrd/report/excel03');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2003</label></a>
						<a href="<?php echo site_url('hrd/report/excel07');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2007</label></a></p>-->
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table <?php if(!empty($list_stockatk))
												 {
												 echo 'id="example1"';
												 } 
												 
												 ?> class="table table-bordered table-striped" >
                                        <thead>
											<tr>
												<th align="justify">Nama</th>
												<th align="justify">NIP</th>
												<th align="justify">Departement</th>
												<th align="justify">Jabatan</th>
												<th align="justify">Ijin </th>
												<th align="justify">Terlambat </th>
												<th align="justify">tanggal Terlambat </th>
												<th align="justify">Keterangan </th>
												<th align="justify">Jumlah Cuti </th>
																							
											</tr>
										</thead>
                                        <tbody>
                                            <?php
												 //Menampilkan data turn over yang ada
												 if(empty($list_stockatk))
												 {
												 echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
												 }else
												 {
												 foreach($list_stockatk as $column)
												 {
												?>
											  <tr>
												 
												
												<td><?php echo $column->nmlengkap;?></td>
												<td><?php echo $column->nip;?></td>
												<td><?php echo $column->deskripsi;?></td>
												<td><?php echo $column->deskripsi;?></td>
												<td><?php echo $column->ijin;?></td>
												<td><?php echo $column->terlambat;?></td>
												<td><?php echo $column->tgl;?></td>
												<td><?php echo $column->desc_att;?></td>
												<td><?php echo $column->jmlcuti;?></td>
												
												
												
												
											  </tr>	
											<?php }} ?>
                                        </tbody>                                        
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
					
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Turn Over</h4> 
      </div>
      <div class="modal-body">     				
				<form class="form-horizontal" action="<?php echo site_url('hrd/report/index');?>" method="post" name="frmGISRequest" onload="disableSelects(document.forms['frmGISRequest'])">

					<div class="form-group">
						<label class="col-lg-3">Tahun</label>	
							<div class="col-lg-5">    
								<select class='form-control' name="tahun">
								  <option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
								  <option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
								  <option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
								</select>
							</div>
							
					</div>

					
					<div class="form-group" style="display:none">
						<label class="col-lg-3">Periode</label>	
							<div class="col-lg-9" style="display:none">   
								
								<div class="col-md-3">
								<input type="radio" name="mype" value="value1" onClick="Hide('pertriwulan', this); Reveal('perthn', this); Hide('perbulan', this);Hide('persemester', this)" />1 Tahun
								</div>
								<div class="col-md-3">
								<input type="radio" name="mype" value="value2" onClick="Hide('perthn', this);Hide('pertriwulan', this); Reveal('perbulan', this);Hide('persemester', this)" />Bulan
								</div>
								<div class="col-md-3">
								<input type="radio" name="mype" value="value3" onClick="Hide('perthn', this);Hide('perbulan', this); Reveal('pertriwulan', this);Hide('persemester', this)" checked/>Triwulan
								</div>
								<div class="col-md-3">
								<input type="radio" name="mype" value="value4" onClick="Hide('perthn', this);Hide('perbulan', this); Hide('pertriwulan', this);Reveal('persemester', this)" />semester
								</div>
								
							</div>
							
							<div id='perthn' style="display:none" >Laporan Satu Tahun Penuh</div>
							<div class="col-md-5" id="perbulan" style="display:none">
								<select class='form-control' name="bulan">
									<option value="jan">Januari</option>				  
									<option value="feb">Februari</option>				  
									<option value="mar">Maret</option>				  
									<option value="apr">April</option>				  
									<option value="mei">Mei</option>				  
									<option value="jun">Juni</option>				  
									<option value="jul">Juli</option>				  
									<option value="ags">Agustus</option>				  
									<option value="sep">September</option>				  
									<option value="okt">Oktober</option>				  
									<option value="nov">November</option>				  
									<option value="des">Desember</option>				  
								</select>
							</div>
							<div class="col-lg-5" id="pertriwulan" >
								<select class='form-control' name="triwulan">
									<option value="tri1">Triwulan Pertama</option>				  
									<option value="tri2">Triwulan Kedua</option>				  
									<option value="tri3">Triwulan Ketiga</option>				  
									<option value="tri4">Triwulan Keempat</option>				  
								</select>
							</div>
							<div class="col-md-5" id="persemester" style="display:none">
								<select class='form-control' name="smster">
									<option value="smst1">Semester Pertama</option>				  
									<option value="smst2">Semester Kedua</option>				  
												  
								</select>
							</div>
					</div>
					<?php if ($this->session->userdata('level')=='A') { ?>
					<div class="form-group">						
						<label class="col-lg-3">Area</label>
						<div class="col-lg-5">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" name="ck_area" value='yes'>
								</span>
									<select class='form-control' name="area" >
									<?php
										foreach($qarea as $column){						
										echo '<option value="'.$column->nip.'">'.$column->nip.'</option>';
										} ?>
								  <option value="NA">NASIONAL</option>
								  <option value="NA"><?php echo $this->session->userdata('level');?></option>
								</select>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->							
					</div>
					<?php } ?>
					<div class="form-group">
						<label class="col-lg-3">Kategori</label>	
						<div class="col-lg-5">
							<div class="input-group">
								<span class="input-group-addon">
									<input type="checkbox" name="ck_kategori" value='yes'>
								</span>
									<select class='form-control' name="kategori">
										<?php
										//Menampilkan data turn over yang ada
										if(empty($qkategori))
										{
											echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
										}else
										{
											foreach($qkategori as $column)
											{
											?>
											<option value="<?php echo $column->FC_TGTKATEGORI; ?>"><?php echo $column->FV_TGTNAME; ?></option>
											<?php }} ?>
									</select>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->						
					</div>					   												
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i>Proses</button>
      </div>
	  </form>
    </div>
  </div>
</div>