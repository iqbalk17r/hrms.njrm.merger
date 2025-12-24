<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Backupdb extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
	
		
		$this->load->model(array('m_backupdb'));
        $this->load->library(array('form_validation','template','upload','pdf','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption'));
        $this->load->helper('file');
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        
		$data['title']="Selamat Datang Di Modul Bantuan Backup Database";
		$nama=$this->session->userdata('nama');
		
       	$paramerror=" and userid='$nama' and modul='BACKUP'";	
		$dtlerror=$this->m_backupdb->q_trxerror($paramerror)->row_array();
		$count_err=$this->m_backupdb->q_trxerror($paramerror)->num_rows();
		if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
		if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
		if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }
		
		if($count_err>0 and $errordesc<>''){
			if ($dtlerror['errorcode']==0){
				$data['message']="<div class='alert alert-info'>DATA BACKUP SUKSES DISIMPAN $nomorakhir1 </div>";
			} else {
				$data['message']="<div class='alert alert-info'>$errordesc</div>";
			}
			
		}else {
			if ($errorcode=='0'){
				$data['message']="<div class='alert alert-info'>DATA BACKUP SUKSES DISIMPAN $nomorakhir1 </div>";
			} else {
				$data['message']="";
			}
			
		}	
		
		$data['dtlbackupdb']=$this->m_backupdb->q_backupdb()->row_array();
        $this->template->display('bantuan/backupdb/v_backupdb',$data);
		
		$paramerror=" and userid='$nama'";
		$dtlerror=$this->m_backupdb->q_deltrxerror($paramerror);
    }
	
	function proses_backup(){
		$nama=$this->session->userdata('nama');
		$dbname=$this->db->database ;
		$dbpassword=$this->db->password ;
		
		$schedule=$this->input->post('schedule');
		$path_bin=$this->input->post('path_bin');
		$path_source=$this->input->post('path_source');
		$dbtype='postgres';
		$dbuname=$this->input->post('dbuname');
		$backuptype=$this->input->post('backuptype');
		$inputby=$this->session->userdata('nama');
		$inputdate=date('Y-m-d H:i:s');
		if($schedule=='daily'){
			switch(date('D')){
				case 'Mon' : $prf='SENIN'; break;
				case 'Tue' : $prf='SELASA'; break;
				case 'Wed' : $prf='RABU'; break;
				case 'Thu' : $prf='KAMIS'; break;
				case 'Fri' : $prf='JUMAT'; break;
				case 'Sat' : $prf='SABTU'; break;
				default	   : $prf='MINGGU';
			}
			$prefix='_'.$prf;
		} else {
			$prefix=date('YmdHi');
		}
		
		
		$filefolder=$path_source;
		$filebin=$path_bin."pg_dump.exe";
		if (file_exists($filefolder) and file_exists($filebin)) {
			//exec("D:/WAPP/postgresql/bin/pg_dump.exe --dbname=postgresql://postgres:root@127.0.0.1:5432/DBPNJ1 > DBPNJ1.backup",$output);
			exec($path_bin."pg_dump.exe --dbname=postgresql://".$dbtype.":".$dbpassword."@127.0.0.1:5432/".$dbname." > ".$path_source.$dbname.$prefix.".".$backuptype,$output);
			//print_r($output);
			echo $path_bin."pg_dump.exe --dbname=postgresql://".$dbtype.":".$dbpassword."@127.0.0.1:5432/".$dbname." > ".$path_source.$dbname.$prefix.".".$backuptype;
			$info = array (
					'schedule' => $schedule,
					'dbname' => $dbname,
					'dbpassword' => $dbpassword,
					'path_bin' => $path_bin,
					'path_source' => $path_source,
					'dbtype' => $dbtype,
					'backuptype' => $backuptype,
					'lastbackupby' => trim($inputby),
					'lastbackupdate' => $inputdate,
					'dbuname' => $dbuname,
			);
			$this->db->update("sc_mst.setupbackup",$info);
			
			$this->db->where('userid',$nama);
			$this->db->where('modul','BACKUP');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array (
				'userid' => $nama,
				'errorcode' => 0,
				'nomorakhir1' => '',
				'nomorakhir2' => '',
				'modul' => 'BACKUP',
			);
			$this->db->insert('sc_mst.trxerror',$infotrxerror);
			redirect("bantuan/backupdb");
		} else {
			$this->db->where('userid',$nama);
			$this->db->where('modul','BACKUP');
			$this->db->delete('sc_mst.trxerror');
			/* error handling */
			$infotrxerror = array (
				'userid' => $nama,
				'errorcode' => 1,
				'nomorakhir1' => '',
				'nomorakhir2' => '',
				'modul' => 'BACKUP',
			);
			$this->db->insert('sc_mst.trxerror',$infotrxerror);
			redirect("bantuan/backupdb");
		}
			
		
	}

	function capture_fn(){
        $res =  $this->db->query(" 
select pg_get_functiondef(pp.oid)::text as fn_isi,pn.nspname||'.'||pp.proname as fn_name,
trim(regexp_replace(split_part(split_part(pg_get_functiondef(pp.oid)::text,'RETURNS',1),pn.nspname||'.'||pp.proname,2), '\s+', ' ', 'g')) as fn_isiarg
from pg_proc pp 
inner join pg_namespace pn on (pp.pronamespace = pn.oid)
where proname in 
(select proname
from pg_proc pp
inner join pg_namespace pn on (pp.pronamespace = pn.oid)
inner join pg_language pl on (pp.prolang = pl.oid)
where pl.lanname NOT IN ('c','internal') 
and pn.nspname NOT LIKE 'pg_%'
and pn.nspname <> 'information_schema');
")->result();
        $str="";
        foreach($res as $rw) {
            $fn_fnc = $rw->fn_name.$rw->fn_isiarg;
            $fn_nama = $rw->fn_isiarg;
            $fn_isi = $rw->fn_isi;
            $str .= "/* Function Name $fn_fnc    */";
            $str .= "\n /**/ \n";
            $str .= "\n $fn_isi ;";
            $str .= "\n /**/ \n";
        }
        $tulis = $this->fiky_encryption->blowfish_enkript(urlencode($str),'Xsdfw4');
        if ( ! write_file('./assets/file.php', $tulis))
        {
            echo 'Unable to write the file';
        }
        else
        {
            echo 'File written!';
        }
    }

    function drp_fn(){
        $res =  $this->db->query(" 
select pg_get_functiondef(pp.oid)::text as fn_isi,pn.nspname||'.'||pp.proname as fn_name,
trim(regexp_replace(split_part(split_part(pg_get_functiondef(pp.oid)::text,'RETURNS',1),pn.nspname||'.'||pp.proname,2), '\s+', ' ', 'g')) as fn_isiarg
from pg_proc pp 
inner join pg_namespace pn on (pp.pronamespace = pn.oid)
where proname in 
(select proname
from pg_proc pp
inner join pg_namespace pn on (pp.pronamespace = pn.oid)
inner join pg_language pl on (pp.prolang = pl.oid)
where pl.lanname NOT IN ('c','internal') 
and pn.nspname NOT LIKE 'pg_%'
and pn.nspname <> 'information_schema') ;
")->result();
        $str="";
        foreach($res as $rw) {
            $fn_fnc = $rw->fn_name.$rw->fn_isiarg;
            $fn_nama = $rw->fn_isiarg;
            $fn_isi = $rw->fn_isi;
            $sql = "DROP FUNCTION  $fn_fnc CASCADE;";
            $this->db->query($sql);
        }
        echo 'Drop Success';
    }

    function rest_fn(){
        $MyFile = file_get_contents("./assets/file.php");
        $dex =$this->fiky_encryption->blowfish_dekript($MyFile,'Xsdfw4');
        $this->db->query(urldecode($dex));
        echo 'sukses';
    }

    function test(){
        echo $eni = $this->fiky_encryption->blowfish_enkript("
        HALLO
        ENTER
        ",'Xsdfw4');
        echo '<br>';
        echo $this->fiky_encryption->blowfish_dekript($eni,'Xsdfw4');
        echo '<br>';
        echo $xxy = urlencode("\n coba halo \n test");
        echo urldecode($xxy);
    }
	
	
}	