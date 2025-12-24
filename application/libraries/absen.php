<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/zklib/zklib.php';

class Absen extends ZKLib
{	
	protected $_CI;
	function __construct(){
        $this->_CI=&get_instance();
		$this->_CI->load->model('hrd/m_hrd');
    }

	public function tarik($ipne){						    
		    $zk = new ZKLib($ipne, 4370);    
			$ret = $zk->connect();
			sleep(1);
			if ( $ret ): 
				$zk->disableDevice();
				sleep(1);
			//isi absen
				try {
					
					//$zk->setUser(1, '1', 'Admin', '', LEVEL_ADMIN);
					$user = $zk->getUser();
					sleep(1);
					$nyambung='OK';
					echo $nyambung;
					while(list($uid, $userdata) = each($user)):
						if ($userdata[2] == LEVEL_ADMIN)
							$role = 'ADMIN';
						elseif ($userdata[2] == LEVEL_USER)
							$role = 'USER';
						else
							$role = 'Unknown';
					//var utk isi data
					$idfp=$userdata[0];
					$namafp=$userdata[1];
					$cek=$this->_CI->m_hrd->cek_userfp($ipne,$uid,$idfp,$namafp);	
					$info_userfp=array(
							'ipaddress'=>$ipne,
							'uid'=>$uid,
							'id'=>$userdata[0],
							'nama'=>$userdata[1]
					);
					//input data ke db
					if ($cek->num_rows==0){
						$this->_CI->m_hrd->simpan_tarik_user($info_userfp);			
					}
					endwhile;
				} catch (Exception $e) {
					header("HTTP/1.0 404 Not Found");
					header('HTTP', true, 500); // 500 internal server error                
				}
				//$zk->clearAdmin();
			//end isi absen
			$zk->enableDevice();
				sleep(1);
				$zk->disconnect();
			endif;			
	}
	public function logfp($ipne){
		$zk = new ZKLib($ipne, 4370);
		$ret = $zk->connect();
		sleep(1);
		if ( $ret ): 
			$zk->disableDevice();
			sleep(1);
        try {            
            sleep(1);
            } catch (Exception $e) {
                header("HTTP/1.0 404 Not Found");
                header('HTTP', true, 500); // 500 internal server error                
            }
            //$zk->clearAdmin();
            $attendance = $zk->getAttendance();
            sleep(1);
            while(list($idx, $attendancedata) = each($attendance)):
                $wktceklog=date( "H:i:s", strtotime( $attendancedata[3] ) );
				$brgktawl=date( "H:i:s", strtotime( "06:00:00" ) );
				$brgktakhr=date( "H:i:s", strtotime( "11:30:00" ) );
				$plgawl=date( "H:i:s", strtotime( "13:00:00" ) );
				$plgakhr=date( "H:i:s", strtotime( "20:00:00" ) );
				if ( $wktceklog>$brgktawl && $wktceklog<$brgktakhr  ) {
                    $status = 'IN'; }
                else if ( $wktceklog>$plgawl && $wktceklog<$plgakhr  ) {
                    $status = 'OUT';            
				} else {
					$status = 'INOUT';
				}
				/*
                echo $idx.'|';
                echo $attendancedata[0].'|';
                echo $attendancedata[1].'|';
				echo $status.'|';
                echo date( "d-m-Y", strtotime( $attendancedata[3] ) ).'|';
                echo date( "H:i:s", strtotime( $attendancedata[3] ) ).'|';    
				echo '</br>';
				*/
					$userid=$attendancedata[0];										
					$uid=strtoupper($attendancedata[1]);										
					$cktype=$status;
					$ckdate=date( "d-m-Y", strtotime( $attendancedata[3] ) );
					$cktime=date( "H:i:s", strtotime( $attendancedata[3] ) );
					$uid=$attendancedata[0];
				$cekfp=$this->_CI->m_hrd->cek_idlogfp($userid,$uid,$ipne,$cktype,$ckdate,$cktime);					
				//input data ke db
					if ($cekfp->num_rows==0){
						$this->_CI->m_hrd->simpan_logatt($userid,$uid,$ipne,$cktype,$ckdate,$cktime);		
					}				
            endwhile;         
        $zk->enableDevice();
        sleep(1);
        $zk->disconnect();
    endif;
	}
}
