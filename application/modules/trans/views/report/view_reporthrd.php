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
						<a href="<?php echo site_url('laporan/rkap/input/');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-plus"></i><font color="#fffff"><b>INPUT</b></font></a>                                
						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style=" margin:10px"><i class="glyphicon glyphicon-search"></i> FILTER</a>                                																
						<p align='right' style='margin-right:10px'>Download Laporan :
						<a href="<?php echo site_url('laporan/rkap/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a>
						<a href="<?php echo site_url('laporan/rkap/excel03');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2003</label></a>
						<a href="<?php echo site_url('laporan/rkap/excel07');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2007</label></a></p>
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table <?php if(!empty($qrkap))
												 {
												 echo 'id="example1"';
												 } 
												 
												 ?> class="table table-bordered table-striped" >
                                        <thead>
											<tr>
												<th align="justify">Action</th>
												<th align="justify">Wilayah</th>
												<th align="justify">Tahun</th>
												<th align="justify">Kategori</th>
												<th align="justify">Januari </th>
												<th align="justify">Februari </th>
												<th align="justify">Maret </th>
												<th align="justify">April </th>
												<th align="justify">Mei </th>
												<th align="justify">Juni </th>
												<th align="justify">Juli </th>
												<th align="justify">Agustus </th>
												<th align="justify">September </th>
												<th align="justify">Oktober </th>
												<th align="justify">November </th>
												<th align="justify">Desember </th>
												<th align="justify">Total </th>												
											</tr>
										</thead>
                                        <tbody>
                                            <?php
												 //Menampilkan data RKAP yang ada
												 if(empty($qrkap))
												 {
												 echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
												 }else
												 {
												 foreach($qrkap as $column)
												 {
												?>
											  <tr>
												 
												<td><a href="<?php echo site_url('laporan/rkap/edit/'.$column->FN_ID_RKAP);?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
												|<a href="<?php echo site_url('laporan/rkap/hapus/'.$column->FN_ID_RKAP);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data RKAP <?php echo $column->kategori;?> Tahun <?php echo $column->tahun;?> Area <?php echo $column->area;?>?')"><i class="glyphicon glyphicon-trash"></i></a></td>
												<td><?php echo $column->area;?></td>
												<td><?php echo $column->tahun;?></td>
												<td><?php echo $column->kategori;?></td>
												<td align="right"><?php echo number_format($column->jan,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->feb,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->mar,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->apr,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->mei,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->jun,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->jul,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->ags,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->sep,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->okt,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->nov,0,',','.');?></td>
												 <td align="right"><?php echo number_format($column->des,0,',','.');?></td>
												 <?php $total=$column->jan+$column->feb+$column->mar+$column->apr+$column->mei+$column->jun+$column->jul+$column->ags+$column->sep+$column->okt+$column->nov+$column->des;?>
												 <td align="right"><?php echo number_format($total,0,',','.');?></td>
												
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
        <h4 class="modal-title" id="myModalLabel">Filter RKAP</h4> 
      </div>
      <div class="modal-body">     				
				<form class="form-horizontal" action="<?php echo site_url('laporan/rkap/index');?>" method="post" name="frmGISRequest" onload="disableSelects(document.forms['frmGISRequest'])">

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
										echo '<option value="'.$column->FC_AREA.'">'.$column->FV_AREANAME.'</option>';
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
										//Menampilkan data RKAP yang ada
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