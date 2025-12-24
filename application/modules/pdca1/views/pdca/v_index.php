<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

</style>
<script type="text/javascript">
            $(function() {
				$("#example1").dataTable({
					"autoWidth": false
				});
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				/*$('#example1').bootstrapTable({
						resizable: true,
						headerOnly: true,
						data: data
				});*/
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<legend><?php echo $title;?></legend>
	
<script>

  

	
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tgl").datepicker(); 
    	$(".tglan").datepicker(); 
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years", 
					minViewMode: "years"
				
				});
  

</script>