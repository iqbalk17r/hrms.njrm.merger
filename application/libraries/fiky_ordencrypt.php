<?php
/*Created By Fiky*/

class Fiky_OrdEncrypt
{

	function coba(){
        //$this->load->library('pro');
        //echo $this->pro->show_hello_world();
       return 'TEST';
    }
    /* ENCRYPT */
	function encrypt($param1){
		   $dsc1='902451387651497';
		   $param_answer=substr($param1.'               ',0,15);
		   $jwb1='';
		   $fkt=1;
		   $pjg=strlen($param_answer)-1;
		
		for( $ctr=0; $ctr <= $pjg ; $ctr++ ) {
			  $tmp1=$param_answer[$ctr];
			  $tmp2=ord($tmp1)+((ord($dsc1[$ctr])-35)*$fkt);
			  $jwb1=$jwb1.chr($tmp2);
		}
		     
		 return $jwb1;
	}
	/* DECRYPT */
	function decrypt($param1){
		   $dsc1='902451387651497';
		   $param_answer=substr($param1.'               ',0,15);
		   $jwb1='';
		   $fkt=-1;
		   $pjg=strlen($param_answer)-1;
		
		for( $ctr=0; $ctr <= $pjg ; $ctr++ ) {
			  $tmp1=$param_answer[$ctr];
			  $tmp2=ord($tmp1)+((ord($dsc1[$ctr])-35)*$fkt);
			  $jwb1=$jwb1.chr($tmp2);
		}
		     
		 return $jwb1;
	}
}
