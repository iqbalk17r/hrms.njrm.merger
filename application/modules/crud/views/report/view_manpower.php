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
						<a href="<?php echo site_url('hrd/report');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-plus"></i><font color="#fffff"><b>INPUT</b></font></a>                                
						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style=" margin:10px"><i class="glyphicon glyphicon-search"></i> FILTER</a>                                																
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table <?php if(!empty($list_manpower))
												 {
												 echo 'id="example1"';
												 } 												 
												 ?> class="table table-bordered table-striped" style="width:100%;" >
                                        <thead>
											<tr>
											  <th colspan="25" align="justify"><div align="center"><em>Man Power</em></div></th>
										  </tr>
											<tr>
											  <th rowspan="2"></th>
											  <th rowspan="2">No</th>
											  <th  rowspan="2" align="justify"><div align="center">Departement</div></th>
											  <th  rowspan="2" align="justify"><div align="center">Total </div></th>
											  <th colspan="4" align="justify"><div align="center">Pendidikan </div></th>
												<th colspan="2" align="justify"><div align="center">DEMAK</div></th>
												<th colspan="2" align="justify"><div align="center">SEMARANG</div></th>
											    <th colspan="2" align="justify"><div align="center">SURABAYA</div></th>
											    <th colspan="2" align="justify"><div align="center">JAKARTA</div></th>
										      <th colspan="3" align="justify"><div align="center">ABSENTEEISM</div></th>
										      <th colspan="2" align="justify"><div align="center">IN</div></th>
										      <th colspan="3" align="justify"><div align="center">OUT</div></th>
										      <th rowspan="2" align="justify"><div align="center">END OF MONTH</div></th>
										  </tr>
											<tr>
											  <th  align="justify"><div align="center">Sarjana</div></th>
											  <th  align="justify"><div align="center">Diploma</div></th>
										      <th  align="justify"><div align="center">SLTA</div></th>
										      <th  align="justify"><div align="center">SMP</div></th>
										      <th  align="justify"><div align="center">M</div></th>
										      <th  align="justify"><div align="center">F</div></th>
											  <th  align="justify"><div align="center">M</div></th>
										      <th  align="justify"><div align="center">F</div></th>
										      <th  align="justify"><div align="center">M</div></th>
										      <th  align="justify"><div align="center">F</div></th>
										      <th  align="justify"><div align="center">M</div></th>
										      <th  align="justify"><div align="center">F</div></th>
										      <th  align="justify"><div align="center">PER</div></th>
										      <th  align="justify"><div align="center">DAYS</div></th>
										      <th  align="justify"><div align="center">%</div></th>
										      <th  align="justify"><div align="center">New Emp</div></th>
										      <th  align="justify"><div align="center">Mutation</div></th>
										      <th  align="justify"><div align="center">Resign</div></th>
										      <th  align="justify"><div align="center">Dead</div></th>
										      <th  align="justify"><div align="center">Mutasi</div></th>
									      </tr>
										</thead>
                                        <tbody>
                                            <?php
												 //Menampilkan data turn over yang ada
												 if(empty($list_manpower))
												 {
												 echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
												 }else
												 { $no=1;
												 foreach($list_manpower as $mp)
												 {
												?>
											  <tr>
												<td width="0.01%"><?php echo $no; $no++;?></td>
												<td><?php if ($mp->urut=='1') {echo "<b>$mp->nomor</b>";}?></td>
												<td>
													<?php 
														if ($mp->urut=='1') {echo "<b>$mp->dept: $mp->subdept</b>";} 
														else if ($mp->urut=='2') {echo "<li>$mp->jabt</li>";}												
														else if ($mp->urut=='3') {echo "<b>$mp->jabt</b>";}												
														else if ($mp->urut=='4') {echo "<b>$mp->jabt</b>";}												
													?>
												</td>
											    <td align="center" valign="middle"><div align="center"><?php echo $mp->ttl;?></div></td>
											    <td><?php echo $mp->srj;?></td>
											    <td><?php echo $mp->dpm;?></td>
											    <td><?php echo $mp->sma;?></td>
											    <td><?php echo $mp->smp;?></td>									            
									            <td><?php echo $mp->dmkm;?></td>
									            <td><?php echo $mp->dmkf;?></td>
									            <td><?php echo $mp->cndm;?></td>
									            <td><?php echo $mp->cndf;?></td>
									            <td><?php echo $mp->mrgm;?></td>
									            <td><?php echo $mp->mrgf;?></td>
									            <td><?php echo $mp->kpkm;?></td>
									            <td><?php echo $mp->kpkf;?></td>
									            <td>&nbsp;</td>
									            <td>&nbsp;</td>
									            <td>&nbsp;</td>
									            <td><?php echo $mp->newemp;?></td>
									            <td>&nbsp;</td>
									            <td><?php echo $mp->resign;?></td>
									            <td>&nbsp;</td>
									            <td>&nbsp;</td>
									            <td>&nbsp;</td>
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