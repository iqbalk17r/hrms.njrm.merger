<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Filetrans extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_filetrans'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		$nama=$this->session->userdata('nik');
		$data['title']="List Master Agama";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$data['list_agama']=$this->m_filetrans->q_agama()->result();
		//$data['message']="List SMS Masuk";
        $this->template->display('master/agama/v_agama',$data);
    }

	function dl_file($file){
	   if (!is_file($file)) { die("<b>404 File not found!</b>"); }
	   $len = filesize($file);
	   $filename = basename($file);
	   $file_extension = strtolower(substr(strrchr($filename,"."),1));
	   $ctype="application/force-download";
	   header("Pragma: public");
	   header("Expires: 0");
	   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	   header("Cache-Control: public");
	   header("Content-Description: File Transfer");
	   header("Content-Type: $ctype");
	   $header="Content-Disposition: attachment; filename=".$filename.";";
	   header($header );
	   header("Content-Transfer-Encoding: binary");
	   header("Content-Length: ".$len);
	   @readfile($file);
	   exit;
	}
	
	function backup_db(){
		$nama=$this->session->userdata('nik');
		$data['title']="Backup Database Server";
		
		if($this->uri->segment(4)=="conn_failed")
            $data['message']="<div class='alert alert-warning'>Koneksi Ke DATABASE Gagal</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		//print_r($this->db);
		
		///$dbname=$this->db->database;                       
		///$dbhost=$this->db->hostname;
		///$dbuser=$this->db->username;
		///$dbpass=$this->db->password;
		$action = trim($this->input->post("actionButton"));
		$dbname = trim($this->input->post("dbname"));
		///$dbhost = trim($this->input->post("dbhost"));
		$dbhost = 'localhost';
		$dbuser = trim($this->input->post("udb"));
		$dbpass = trim($this->input->post("pdb"));
		$dayofbackup = trim($this->input->post("dayofbackup"));
		$backup_type = trim($this->input->post("backup_type"));
		
		//$action  = $_POST["actionButton"];
		//$action = $this->input->post("actionButton");
		//$ficheiro= $_FILES["path"]["name"];
		switch ($action) {
			case "Import":
			///  $dbname = "CNI"; //database name
			  $dbconn = pg_pconnect("host=localhost port=5432 dbname=$dbname 
		user=postgres password=root"); //connectionstring
			  if (!$dbconn) {
				echo "Can't connect.\n";
				exit;
			  }
			  $back = fopen($ficheiro,"r");
			  $contents = fread($back, filesize($ficheiro));
			  $res = pg_query(utf8_encode($contents));
			  echo "Upload Ok";
			  fclose($back);
		  break; 
			  case "Export":
			  $dbname = "HRDNUSANEW"; //database name
			  $dbconn = pg_pconnect("host=localhost port=5432 dbname=$dbname 
			user=postgres password=root"); //connectionstring
			  if (!$dbconn) {
				echo "Can't connect.\n";
			  exit;
			  }
			  $back = fopen("$dbname.sql","w");
			/*
			  $res = pg_query(" select relname as tablename
								from pg_class where relkind in ('r')
								and relname not like 'pg_%' and relname not like 
			'sql_%' order by tablename");
			*/
					$res = pg_query("select 
								(trim(nsp.nspname)||'.'||trim(cls.relname))::name as tabelnya, cls.relname
								from pg_class cls
								  join pg_roles rol on rol.oid = cls.relowner
								  join pg_namespace nsp on nsp.oid = cls.relnamespace
								where nsp.nspname not in ('information_schema', 'pg_catalog')
								  and nsp.nspname not like 'pg_toast%'
								  and cls.relkind = 'r'
								  and rol.rolname = current_user  --- remove this if you want to see all objects
								order by nsp.nspname, cls.relname");


			  $str="";
			  while($row = pg_fetch_row($res))
			  {
				$table = $row[0];
				$table_rel = $row[1];
				$str .= "\n--\n";
				$str .= "-- Estrutura da tabela '$table'";
				$str .= "\n--\n";
				$str .= "\nDROP TABLE $table CASCADE;";
				$str .= "\nCREATE TABLE $table (";
				$res2 = pg_query("
				SELECT  attnum,attname , typname , atttypmod-4 , attnotnull 
			,atthasdef ,adsrc AS def
				FROM pg_attribute, pg_class, pg_type, pg_attrdef WHERE 
			pg_class.oid=attrelid
				AND pg_type.oid=atttypid AND attnum>0 AND pg_class.oid=adrelid AND 
			adnum=attnum
				AND atthasdef='t' AND lower(relname)='$table_rel' UNION
				SELECT attnum,attname , typname , atttypmod-4 , attnotnull , 
			atthasdef ,'' AS def
				FROM pg_attribute, pg_class, pg_type WHERE pg_class.oid=attrelid
				AND pg_type.oid=atttypid AND attnum>0 AND atthasdef='f' AND 
			lower(relname)='$table_rel' ");                                             
				while($r = pg_fetch_row($res2))
				{
				$str .= "\n" . $r[1]. " " . $r[2];
				 if ($r[2]=="varchar")
				{
				$str .= "(".$r[3] .")";
				}
				if ($r[4]=="t")
				{
				$str .= " NOT NULL";
				}
				if ($r[5]=="t")
				{
				$str .= " DEFAULT ".$r[6];
				}
				$str .= ",";
				}
				$str=rtrim($str, ",");  
				$str .= "\n);\n";
				$str .= "\n--\n";
				$str .= "-- Creating data for '$table'";
				$str .= "\n--\n\n";

				
			$res3 = pg_query("SELECT * FROM $table");
				
				///$res3 = $this->db->query("SELECT * FROM $table_rel");
				while($r = pg_fetch_row($res3))
				{
				  $sql = "INSERT INTO $table VALUES ('";
				  $sql .= utf8_decode(implode("','",$r));
				  $sql .= "');";
				  $str = str_replace("''","NULL",$str);
				  $str .= $sql;  
				  $str .= "\n";
				}
				
				 $res1 = pg_query("SELECT pg_index.indisprimary,
						pg_catalog.pg_get_indexdef(pg_index.indexrelid)
					FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
						pg_catalog.pg_index AS pg_index
					WHERE c.relname = '$table_rel'
						AND c.oid = pg_index.indrelid
						AND pg_index.indexrelid = c2.oid
						AND pg_index.indisprimary");
				while($r = pg_fetch_row($res1))
				{
				$str .= "\n\n--\n";
				$str .= "-- Creating index for '$table'";
				$str .= "\n--\n\n";
				$t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
				$t = str_replace("USING btree", "|", $t);
				// Next Line Can be improved!!!
				$t = str_replace("ON", "|", $t);
				$Temparray = explode("|", $t);
				$str .= "ALTER TABLE ONLY ". $table . " ADD CONSTRAINT " . 
				$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
				}   
			  }
			  $res = pg_query(" SELECT
			  cl.relname AS tabela,ct.conname,
			   pg_get_constraintdef(ct.oid)
			   FROM pg_catalog.pg_attribute a
			   JOIN pg_catalog.pg_class cl ON (a.attrelid = cl.oid AND cl.relkind = 'r')
			   JOIN pg_catalog.pg_namespace n ON (n.oid = cl.relnamespace)
			   JOIN pg_catalog.pg_constraint ct ON (a.attrelid = ct.conrelid AND
			   ct.confrelid != 0 AND ct.conkey[1] = a.attnum)
			   JOIN pg_catalog.pg_class clf ON (ct.confrelid = clf.oid AND 
			clf.relkind = 'r')
			   JOIN pg_catalog.pg_namespace nf ON (nf.oid = clf.relnamespace)
			   JOIN pg_catalog.pg_attribute af ON (af.attrelid = ct.confrelid AND
			   af.attnum = ct.confkey[1]) order by cl.relname ");
			  while($row = pg_fetch_row($res))
			  {
				$str .= "\n\n--\n";
				$str .= "-- Creating relacionships for '".$row[0]."'";
				$str .= "\n--\n\n";
				$str .= "ALTER TABLE ONLY ".$table . " ADD CONSTRAINT " . $row[1] . 
			" " . $row[2] . ";";
			  }       
			  fwrite($back,$str);
			  fclose($back);
			  dl_file("$dbname.sql");
			  break;
		}

		$data['list_backup']=$this->m_filetrans->q_im_backup_db()->result();
        $this->template->display('master/filetrans/v_filetrans',$data);
	}
	
	function test(){
		$res = pg_query("select 
						(trim(nsp.nspname)||'.'||trim(cls.relname))::name as tablename,cls.relname as tablerel
						from pg_class cls
						  join pg_roles rol on rol.oid = cls.relowner
						  join pg_namespace nsp on nsp.oid = cls.relnamespace
						where nsp.nspname not in ('information_schema', 'pg_catalog')
						  and nsp.nspname not like 'pg_toast%'
						  and cls.relkind = 'r'
						  and rol.rolname = current_user  --- remove this if you want to see all objects
						order by nsp.nspname, cls.relname");
		
		  $str="";
		  while($row = pg_fetch_row($res))
		  {	
			$table = $row[0];
			$table_rel = $row[1];
		   echo '</br>';
			$res3 = pg_query("SELECT * FROM $table");
				while($r = pg_fetch_row($res3)){
					$sql = "INSERT INTO $table VALUES ('";
					$sql .= utf8_decode(implode("','",$r));
					$sql .= "');";
					echo $str = str_replace("''","NULL",$str);
					echo $str .= $sql;  
					echo $str .= "\n";
					
				
					
					
				}
					
				
				///$res3 = $this->db->query("SELECT * FROM $table_rel");
				///while($r = pg_fetch_row($res3))
				///{
				///  $sql = "INSERT INTO $table VALUES ('";
				///  $sql .= utf8_decode(implode("','",$r));
				///  $sql .= "');";
				///  $str = str_replace("''","NULL",$str);
				///  $str .= $sql;  
				///  $str .= "\n";
				///}
		  }
	}
	
	// function run_cmd(){
	/*	system("cmd /c 
		@echo off
				color 7f
				cd /D %~dp0

				cls
				SET PGPATH=D:\web\postgresql\bin\
				SET SVPATH=D:\Schedular\DBNYA\
				SET PRJDB=CNI
				SET DBUSR=postgres



				FOR /F 'TOKENS=1,2,3 DELIMS=/ ' %%i IN ('DATE /T') DO SET d=%%i-%%j-%%k
				FOR /F 'TOKENS=1,2,3 DELIMS=: ' %%i IN ('TIME /T') DO SET t=%%i%%j%%k

				SET DBDUMP=%PRJDB%_%d%_%t%.backup


				title BACKUP WEB NUSA JANGAN DITUTUP!!

				%PGPATH%pg_dump.exe --host localhost --port 5432 --username '%DBUSR%' --no-password  --format custom --blobs --verbose --file '%SVPATH%%DBDUMP%' '%PRJDB%'

				SET PRJDB=CNI
				SET DBDUMP=%PRJDB%_%d%_%t%.backup

				echo Backup Taken Complete %SVPATH%%DBDUMP%
		
		");*/

			// echo $hiya=" D:\web\postgresql\bin\ ";
		
			// echo "@echo off";
			// echo "color 7f";
			// echo "cd /D %~dp0";
			// echo "cls";
			// echo 'SET PGPATH='.$hiya';

		
	}