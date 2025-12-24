<?php
/*Created By Fiky*/

class Fiky_string
{

	function coba(){
        //$this->load->library('pro');
        //echo $this->pro->show_hello_world();
       return 'TEST';
    }
    function stringsatu($maxstring,$charstring){	
		$strform=$maxstring;
		$stringya=trim($charstring);
		$nama=strlen(substr($stringya,0,$strform));
			$nama;
			$kondisi=substr($stringya,$nama,1);
		
		if($nama>=$strform){
				if($kondisi==' ' or $kondisi=='.' or $kondisi==',' ){
					$strform=$strform+1;
					$stringone=substr($stringya,0,$strform); 
					$strlast=strlen(substr($stringya,0,$strform));
					} 
				else{
					for ($i=$nama ;$i>0 ;$i--){
							$kondisi2=substr($stringya,$i,1);
								if($kondisi2==' ' or $kondisi2=='.' or $kondisi2==','){
										$i=$i+1;
										$stringone=substr($stringya,0,$i);
										$strlast=strlen(substr($stringya,0,$i));
										break;}
					} //echo $i;
					//echo substr($dtl_kar['nmlengkap'],$nama+1,30);
				}
		}else{				
					
			if($kondisi==' ' or $kondisi=='.' or $kondisi==',' or $nama<=$strform){
					$strform=$strform+1;
					$stringone=substr($stringya,0,$strform); 
				
					} 
				else{
					for ($i=$nama ;$i>0 ;$i--){
							$kondisi2=substr($stringya,$i,1);
								if($kondisi2==' ' or $kondisi2=='.' or $kondisi2==','){
										$i=$i+1;
										$stringone=substr($stringya,0,$i); 
										
										break;
										
										}
					} 
					//echo substr($dtl_kar['nmlengkap'],$nama+1,30);
				}	
		}
		return $stringone;
	}

  function stringdua($maxstring,$charstring){
	  
		$stringsatunya=$this->stringsatu($maxstring,$charstring);
		
		$strform=$maxstring;
		$strstart=strlen($stringsatunya);
		$stringya=trim($charstring);
		$nama=strlen(substr($stringya,$strstart,$strform));
			$nama;
			$kondisi=substr($stringya,$nama,1);
		
		if($nama>=$strform){
				if($kondisi==' ' or $kondisi=='.' or $kondisi==',' ){
					$strform=$strform+1;
					$stringtwo=substr($stringya,$strstart,$strform); 
					
					} 
				else{
					for ($i=$nama ;$i>0 ;$i--){
							$kondisi2=substr($stringya,$i,1);
								if($kondisi2==' ' or $kondisi2=='.' or $kondisi2==','){
										$stringtwo=substr($stringya,$strstart,$i);
										
										break;}
					} 
				}
		}else{				
					
			if($kondisi==' ' or $kondisi=='.' or $kondisi==',' or $nama<=$strform){
					$stringtwo=substr($stringya,$strstart,$strform); 
					
					} 
				else{
					for ($i=$nama ;$i>0 ;$i--){
							$kondisi2=substr($stringya,$i,1);
								if($kondisi2==' ' or $kondisi2=='.' or $kondisi2==','){
										$stringtwo=substr($stringya,$strstart,$i); 
										
										break;
										
										}
					} 
				}	
		}
		return $stringtwo;
	}
}
