<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="col-xs-12">     
	<form action="<?php echo site_url('hrd/cuti/add_cuti');?>" name="Form" role="form" method="post">
		<div class="box">
			<div class="box-body" style="margin-top: 20px;">
				<div class="form-horizontal">
					<div class="col-sm-12">
												
					</div>											
				</div>
			</div>
			<div class="box-footer">
				<button type='submit' class='btn btn-primary' onclick="return confirm('Anda Yakin Input Cuti Ini?');" ><i class="glyphicon glyphicon-search"></i>Proses</button>
				<button type='reset' class='btn btn-default' onclick="history.go(-1);" >Kembali</button>
			</div>
		</div>
	</form>
</div>

<div id="tampil"></div>

<script>

    $(function() {
		$("[data-mask]").inputmask();
		$('#tgl1').datepicker();
		$('#tgl2').datepicker();
		$('#tglcuti').daterangepicker("setDate", new Date(2008,9,03));
		});
		
</script>


<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
sisacuti=document.Form.cuti.value;
jmlcuti=document.Form.jml.value;

//sum perbulan
document.Form.sisa.value=(sisacuti*1)-(jmlcuti*1);

}
function stopCalc(){clearInterval(interval)}
</script>