<?php 
/*   	LIST CUTI
	@author : junis 10-12-2012\m/
	@update by: fiky 09/04/2016
*/
?>

<!--script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<!--script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script--->
<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<!--script src="https://code.jquery.com/jquery-3.0.0.js"></script--->

<script type="text/javascript">
            $(function() {
						  $("#CobaUbah").click(function () {
							 $('input:checkbox').not(this).prop('checked', this.checked);
							 console.log('COBA');
						 });
						
						
						  $("#checkAll").click(function () {
							 $('input:checkbox').not(this).prop('checked', this.checked);
						 });	
			 });	
			 
		
</script>

<input type="input" id="CobaUbah">
<input type="checkbox" id="checkAll">Check All
<hr />
<input type="checkbox" id="checkItem">Item 1
<input type="checkbox" id="checkItem">Item 2
<input type="checkbox" id="checkItem">Item3
