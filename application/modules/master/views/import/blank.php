
<!--
ob_start();

echo('doing something...');

// send to browser
ob_flush();

// ... do long running stuff
echo('still going...');

ob_flush();

echo('done.');
ob_end_flush(); 

?-->
<legend><?php echo $title;?></legend>


<?php header ("refresh:5; url: http://localhost/nbiserv01/master/import/blank"); ?>

<!--?php/*

echo 'TEST';


$tes=sleep(20);
if($tes=0){
$this->load->model(array('trans/m_absensi','trans/m_karyawan','m_import')); 
$nodokdir='001';
$j=1000;
for ($i=1;$j>=$i;$i++){
$tes=$this->m_import->i_cek_patch($nodokdir)->row_array();
echo $tes['dir_list'] ;
}
}
sleep(20);
redirect('master/import/i_csv_mstkaryawan/add_success');	
*/

?-->

