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
						<a href="<?php echo site_url('hrd/report');?>" class="btn btn-primary"style=" margin:10px"><i class="glyphicon glyphicon-search"></i><font color="#fffff"><b> FILTER</b></font></a>                                
						<p align='right' style='margin-right:10px'>Download Laporan Attendance :
						<!--<a href="<?php echo site_url('hrd/report/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a>
						<a href="<?php echo site_url('hrd/report/excel03');?>"><i class='fa fa-file-text-o'></i> <label>Excel 2003</label></a>-->
						<a href="<?php echo site_url("hrd/report/excel_attendence/$periode");?>"><i class='fa fa-file-text-o'></i> <label>Excel 2007</label></a></p>
						<div class="box">
                                <div class="box-header">
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table <?php if(!empty($list_att))
												 {
												 echo 'id="example1"';
												 } 
												 
												 ?> class="table table-bordered table-striped" >
                                        <thead>
											<tr>
												<th align="justify">Nik</th>
												<th align="justify">Nama Karyawan</th>
												<th align="justify">Departement</th>
												<th align="justify">Alpha</th>
												<th align="justify">Ijin Keluar</th>
												<th align="justify">Ijin Pulang</th>
												<th align="justify">Ijin Sakit</th>
												<th align="justify">Ijin Datang Terlambat</th>
												<th align="justify">Ijin Menikah</th>
												<th align="justify">Cuti</th>											
											</tr>
										</thead>
                                        <tbody>
                                            <?php
												 //Menampilkan data turn over yang ada
												 if(empty($list_att))
												 {
												 echo "<tr><td colspan=\"8\">Data tidak tersedia</td></tr>";
												 }else
												 {
												 foreach($list_att as $column)
												 {
												?>
											  <tr>
												 
												<td><?php echo $column->nik;?></td>
												<td><?php echo $column->nmlengkap;?></td>
												<td><?php echo $column->nmdept;?></td>
												<td><?php echo $column->alpha;?></td>
												<td><?php echo $column->ij_keluar;?></td>
												<td><?php echo $column->ij_pa;?></td>
												<td><?php echo $column->ij_sakit;?></td>
												<td><?php echo $column->ij_late;?></td>
												<td><?php echo $column->ij_nikah;?></td>
												<td><?php echo $column->cuti;?></td>
												
												
											  </tr>	
											<?php }} ?>
                                        </tbody>                                        
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
					<!--<div id="container"></div>-->
					
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
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Attendance Report'
        },
        subtitle: {
            text: 'PT. NUSA UNGGUL SARANA ADICIPTA'
        },
        xAxis: {
            categories: [
                'TAX',
                'FIN & ACC',
                'IT & QA',
                'HR & GA',
                'LOGISTIK & PENJUALAN',
                'MARKETING',
                'SALES',
                'PROYEK'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'ALPHA',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5]

        }, {
            name: 'IJIN KELUAR',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3]

        }, {
            name: 'IJIN PULANG',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]

        }, {
            name: 'SURAT KETERANGAN DOKTER',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]

        }, {
            name: 'DATANG TERLAMBAT',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]

        }, {
            name: 'PULANG AWAL',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]

        }, {
            name: 'CUTI',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6]

        }
		]
    });
});
		</script>