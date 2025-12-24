
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>

<form action="download/download_zip" method="post">
<table>

<?php
foreach($files as $key=>$file_name){
    echo "<tr><td><input type='checkbox' name='files[]' value='".$file_name."' /></td><td>".$file_name."</td></tr>";
}
?>
</table>
    <input type="text" name="file_name" id="file_name">
    <input type="submit" value="Download" id="download">
</form>
<script type="text/javascript">
	$('form').submit(function() {
    
  		var checked_boxes = $(":checkbox:checked").length;

  		if(checked_boxes < 1){
      			alert("Please Select Files");
      			return false;
  		}else if($('#file_name').val() == ''){
      			alert("Please Enter Name");
      			return false;
  		}
  
	});
</script>
