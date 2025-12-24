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

<?php echo '<h4>NIK : '.$nik.'<br>';?>
			<?php echo 'Nama : '.$nmlengkap.'</h4>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					
					
					<a href="<?php echo site_url("payroll/generate/view_inputresign/$nik");?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nama Komponen</th>	
							<th>Januari (Rp.)</th>								
							<th>Februari (Rp.)</th>								
							<th>Maret (Rp.)</th>								
							<th>April (Rp.)</th>								
							<th>Mei (Rp.)</th>								
							<th>Juni (Rp.)</th>								
							<th>Juli (Rp.)</th>								
							<th>Agustus (Rp.)</th>								
							<th>September (Rp.)</th>								
							<th>Oktober (Rp.)</th>								
							<th>November (Rp.)</th>								
							<th>Desember (Rp.)</th>						
													
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_phh21_resign as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->keterangan;?></td>
							<!--<td><?php echo $lu->uraian;?></td>-->
							<td align="right"><?php echo $lu->januari;?></td>
							<td align="right"><?php echo $lu->februari;?></td>
							<td align="right"><?php echo $lu->maret;?></td>
							<td align="right"><?php echo $lu->april;?></td>
							<td align="right"><?php echo $lu->mei;?></td>
							<td align="right"><?php echo $lu->juni;?></td>
							<td align="right"><?php echo $lu->juli;?></td>
							<td align="right"><?php echo $lu->agustus;?></td>
							<td align="right"><?php echo $lu->september;?></td>
							<td align="right"><?php echo $lu->oktober;?></td>
							<td align="right"><?php echo $lu->november;?></td>
							<td align="right"><?php echo $lu->desember;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					<!--<tfoot>
						<tr>
							<td class="right" colspan="3">Total Pajak:</td><td align="right"><?php echo $total_pajak;?></td> 
						</tr>
					</tfoot>-->
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>









