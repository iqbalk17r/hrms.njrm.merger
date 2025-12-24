<?php    

class Fiky_ddos_protector  {
	
	public function protect(){
	 	try{
			if (!file_exists(dirname(__FILE__) .'/fiky_ddos_protector/anti_ddos/start.php'))
				throw new Exception (dirname(__FILE__) .'/fiky_ddos_protector/anti_ddos/start.php Tidak ada');
			else
				require_once(dirname(__FILE__) .'/fiky_ddos_protector/anti_ddos/start.php'); 
		} 
		//CATCH the exception if something goes wrong.
		catch (Exception $ex) {
			echo '<div style="padding:10px;color:white;position:fixed;top:0;left:0;width:100%;background:green;text-align:center;">The <a href="#" target="_blank">"Protection System"</a> Gagal mendapatkan situs, mohon \'catch Exception\' laporkan yang terjadi!</div>';
			//Print out the exception message.
			//echo $ex->getMessage();
		} 
	}
	
}