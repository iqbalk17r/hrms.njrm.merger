<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 11/04/2019
 * Time: 15:41
 * THIS BASED ENCRYPTION DATA HAS CONFIG URI
 * KNOWLEGDE: HASH ITU SATU ARAH, ENCODING 2 ARAH
 * DEFAULT PHP STANDAR hex2bin(), password_hash(), crypt(), md5(), hash(), sha1(), dan base64_encode()
 */

class Fiky_encryption
{
    protected $_CI;
    function __construct(){
        set_error_handler(
            function ($severity, $message, $file, $line) {
                ///throw new ErrorException($message, $severity, $severity, $file, $line);
            }
        );
        $this->_CI=&get_instance();
        $this->createtable();
        $this->first_template_license();
        $this->onExpireMacLock();
        $this->onExpireLc();
        $this->_CI->load->model(array('master/m_akses'));
        $this->_CI->load->library(array('encrypt','Fiky_version','Fiky_string','Fiky_menu','Important_class','Fiky_wilayah'));
        /* THIS BASED ENCRYPTION DATA HAS CONFIG URI */
    }

    function cobax(){
        return 'TEST';
        /*
         * P1 : STRING
         */
    }
    function enkript($p1){
        $enkripan=bin2hex($this->_CI->encrypt->encode($p1));
        return $enkripan;
    }
    function dekript($p1){
        $dekripan=$this->_CI->encrypt->decode(hex2bin(trim($p1)));
        return $dekripan;
    }
    /* ENCRYPT  BASICALY USER SIDIA E PAK ANDIK */
    function ord_enkript($p1){
        $dsc1='902451387651497';
        $param_answer=substr($p1.'               ',0,15);
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
    /* DECRYPT  BASICALY USER SIDIA E PAK ANDIK  */
    function ord_dekript($p1){
        $dsc1='902451387651497';
        $param_answer=substr($p1.'               ',0,15);
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

    /* BLOWFISH ENCRIPTION */
    function blowfish_enkript($p1, $key) {
        /*based blowfis*/
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, utf8_encode($p1), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    function blowfish_dekript($p1, $key) {
        /*based blowfis*/
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $p1, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

    function bf_fiky_enkript($p1, $key){
        /*based blowfis*/
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, utf8_encode($p1), MCRYPT_MODE_ECB, $iv);
        return urlencode($encrypted_string);
    }
    function bf_fiky_dekript($_p1, $key) {
        $p1 = urldecode($_p1);
        /*based blowfis*/
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $p1, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

    function jDatatable($p1){
        return json_encode(array("dataTables" => $p1));
    }

    function connect_raw(){
        //$json = file_get_contents('https://raw.githubusercontent.com/ikangurame3/hrmsi/master/testing.json');
        $json = file_get_contents('https://raw.githubusercontent.com/ikangurame3/hrmsi/master/sbynsa.json');
        //$json = file_get_contents('https://raw.githubusercontent.com/ikangurame3/hrmsi/master/private.json');
        $obj = json_decode($json, true);
        return $obj;
    }
    function sw_lc(){
        //$this->checkdelfiles();
        $this->createtable();
        $obj = $this->connect_raw();
        $objdb = $this->readpublic_pb()->row_array();
        //$json = file_get_contents('https://raw.githubusercontent.com/ikangurame3/hrmsi/master/message.json');

        $lockstatus = trim($obj['lockstatus']);
        $a_lock_db = $this->bf_fiky_enkript(trim($obj['a_lock_db']),'THIS_KEY_HAS_LIMIT');
        $a_lock_lc = $this->bf_fiky_enkript(trim($obj['a_lock_lc']),'THIS_KEY_HAS_LIMIT');
        $message = trim($obj['message']);
        $lockdate = trim($obj['lockdate']);
        $dnow = date('Y-m-d H:i:s');
        $dbexp = $this->bf_fiky_dekript(trim($objdb['a_7']),'THIS_KEY_HAS_LIMIT');


        $this->onExpireMacLock();

        if ($lockstatus==='YES' and date("Y-m-d H:i:s",strtotime($dbexp)) <= date("Y-m-d H:i:s",strtotime($lockdate))){
            $lockenc = urlencode($this->blowfish_enkript($lockstatus,'THIS_KEY_HAS_LIMIT'));
            $this->_CI->db->query("
                   update public.pb set a_6='$lockenc'; 
                   update sc_his.sh set a_6='$lockenc'; 
                   update sc_tmp.tm set a_6='$lockenc'; 
                   update sc_trx.tx set a_6='$lockenc';  
            ");

            $xhtml  = '';
            $xhtml .= '		<script type="text/javascript">
            document.addEventListener(\'contextmenu\', function(e) {
                e.preventDefault();
            });
            document.onkeydown = function(e) {
                if(event.keyCode == 123) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == \'I\'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == \'C\'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == \'J\'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == \'F\'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == \'V\'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.keyCode == \'U\'.charCodeAt(0)) {
                    return false;
                }
            }
        </script>';
            $xhtml .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>';
            //adding script
            $xhtml .=
                '<script type="text/javascript">
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
   $("#prosesx").attr("disabled", true).text("Checking Data");
   
   var filename = $("#file1").val();
   var extension = filename.replace(/^.*\./, \'\');
        if (extension == filename) {
            extension = \'\';
        } else {
            extension = extension.toLowerCase();
        }
        
        if (extension!=="fiky"){
                alert("Extensi Tidak Sesuai , Harap melampirkan extensi yang sesuai !!!");
                $("#prosesx").attr("disabled", false).text("Proses");
        } else {
                /* start upload */
              var file = _("file1").files[0];
              // alert(file.name+" | "+file.size+" | "+file.type);
              var formdata = new FormData();
              formdata.append("file1", file);
              var ajax = new XMLHttpRequest();
              ajax.upload.addEventListener("progress", progressHandler, false);
              ajax.addEventListener("load", completeHandler, false);
              ajax.addEventListener("error", errorHandler, false);
              ajax.addEventListener("abort", abortHandler, false);
              ajax.open("POST", "'.site_url('lmd/post_lc').'"); 
              //use file_upload_parser.php from above url
              ajax.send(formdata);
              $("#prosesx").attr("disabled", false).text("Proses");
        }
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0; //wil clear progress bar after successful upload
  $("#prosesx").attr("disabled", false).text("Checking Data");
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}
/* end upload progress */
            $(".modal").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false //remove option to close with keyboard
            });
            
            /* ini buat auto show modal
            $("#ChoiceOfLetter").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });*/

                </script>';
            //adding menu
            $xhtml .= '<div class="dropdown">';
            $xhtml .= '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> ?';
            $xhtml .= '<span class="caret"></span></button>';
            $xhtml .= '<ul class="dropdown-menu">';
            $xhtml .= '<li><a href="#"  data-toggle="modal" data-target="#Register"  data-backdrop="static" >Register</a></li>';
            $xhtml .= '<li class="divider"></li>';
            $xhtml .= '<li><a href="#"  data-toggle="modal" data-target="#ChoiceOfLetter"  data-backdrop="static"  >About</a></li>';
            $xhtml .= '</ul>';
            //adding modal
            $xhtml .= '
<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel" align="center"> MODALNYA </h4>
	  </div>
<form action=".'. site_url("#"). '." method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body" align="center">
						'. $message .'
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		
      </div>
	  </form>
</div></div></div>';

            $xhtml .= '
<div class="modal fade" id="Register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel" align="center"> MODALNYA REGISTER </h4>
	  </div>
<form  method="post" enctype="multipart/form-data" id="upload_form">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
									<input type="file" name="file1" id="file1"  class="form-control "  >
<progress id="progressBar" value="0" max="100" style="width:100%;height: 10%; "></progress>
<h3 id="status"></h3>
<p id="loaded_n_total"></p>
							</div>							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <button onclick="uploadFile()" id="prosesx" class="btn btn-primary">PROSES</button>
      </div>
	  </form>
</div></div></div>';
            $xhtml .= '</div>';
        } else {
            $xhtml='';
        }

        echo $xhtml;
    }

    function constant($p1){
        if ($p1=='datatable_language') {
            return "
                \"lengthMenu\": \"Menampilkan _MENU_ data per halaman\",
                \"zeroRecords\": \"Ooooops Maaf Data Tidak Tersedia\",
                \"info\": \"Menampilkan halaman _PAGE_ dari _PAGES_\",
                \"infoEmpty\": \"Ooooops Maaf Data Tidak Tersedia\",
                \"infoFiltered\": \"(filter dari _MAX_ total data tersedia)\",
                \"loadingRecords\": \"Sedang load data...\",
                \"processing\":     \"Sedang Memproses...\",
                \"search\": \"Pencarian _INPUT_\",
                \"paginate\": {
                                \"first\":      \"Awal\",
                                \"last\":       \"Akhir\",
                                \"next\":       \"Lanjut\",
                                \"previous\":   \"Sebelumnya\",
                            },
            ";
        } else {
            return 'NO OBJECT CONSTANTA';
        }

    }

    //function UniqueMachineID($salt = "GARAM") {
    function getMac(){
        $salt = "THIS_KEY_HAS_LIMIT";
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
            if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
            $output = shell_exec("diskpart /s ".$temp);
            $lines = explode("\n",$output);
            $result = array_filter($lines,function($line) {
                return stripos($line,"ID:")!==false;
            });
            if(count($result)>0) {
                $result = array_shift(array_values($result));
                $result = explode(":",$result);
                $result = trim(end($result));
            } else $result = $output;
        } else {
            $result = shell_exec("blkid -o value -s UUID");
            if(stripos($result,"blkid")!==false) {
                //$result = $_SERVER['HTTP_HOST'];
                $result = gethostname();  //JADI NAMA PC HOST
            }
        }
        return md5($salt.md5($result));
        //return $result;
    }

    //function database name($salt = "GARAM") {
    function getDbName(){
        $salt = "THIS_KEY_HAS_LIMIT";
        $dtl = $this->_CI->db->query("SELECT current_database() as dbname")->row_array();
        return $this->bf_fiky_enkript($dtl['dbname'],$salt);
        //return $result;
    }

//    function getMac(){
//        //strtoupper(substr(PHP_OS, 0, 3));
//        //DECISION GET OPERATING SISTEM
//        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
//            //echo 'This is a server using Windows!';
//            ob_start();
//            system('ipconfig /all');
//            $mycomsys=ob_get_contents();
//            ob_clean();
//            $find_mac = "Physical";
//            $pmac = strpos($mycomsys, $find_mac);
//            $macaddress=substr($mycomsys,($pmac+36),17);
//            return $macaddress;
//        } else {
//            //echo 'This is a server not using Windows!';
//            $ipAddress=$_SERVER['REMOTE_ADDR'];
//            $macAddr=false;
//
//#run the external command, break output into lines
//            $arp='arp -a $ipAddress';
//            $lines=explode("\n", $arp);
//
//#look for the output line describing our IP address
//            foreach($lines as $line)
//            {
//                $cols=preg_split('/\s+/', trim($line));
//                if ($cols[0]==$ipAddress)
//                {
//                    $macAddr=$cols[1];
//                }
//            }
//            return $macAddr;
//        }
//
//    }

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

    function codeigniter_environment(){
        /*ambil data */
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_user' => 'ikangurame1@gmail.com',
            'smtp_pass' => 'gakbakalsama',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->_CI->load->library('email', $config);
        $this->_CI->email->set_newline("\r\n");
        $str="
<html>
<head>
<style>
table, th, td {
  border: 1px;
}
</style>
</head>
<body>";
        $res = $this->_CI->db->query("select a.*,b.nmlengkap from sc_his.history_gaji a left outer join sc_mst.karyawan b on a.nik=b.nik where a.periode>='201905' order by a.periode desc, b.nmlengkap asc")->result();
        $str .= "<table>
<tr>
<th>Periode</th>
<th>Nama</th>
<th>Gaji</th>
</tr>";
        foreach($res as $rw) {

            $str .= "<tr>
<td>$rw->periode</td>
<td>$rw->nmlengkap</td>
<td>$rw->nominal</td>
</tr>";

        }
        $str .= "</table> ";
        $str .= "</br> ";
        $str .= "";
        $str .= "</br>";
        $str .= "</body>`
</html>";
        $tulis = $str;
        $penerima='ikangurame3@gmail.com'.',';
        $dari='ikangurame1@gmail.com';
        $subject='HAI DEH';
        $this->_CI->email->from($dari, 'X');
        $this->_CI->email->to($penerima);
        //$this->email->cc($cc);
        //$this->email->bcc($bcc);
        $this->_CI->email->subject($subject);
        $this->_CI->email->message($tulis);

        if ($this->_CI->email->send()) {
            //echo 'Email sent.';
        } else {
            //show_error($this->_CI->email->print_debugger());
        }

    }

    /* check branch*/
    function readbranch(){
        return $this->_CI->db->query("
                   select * from sc_mst.branch where cdefault='YES'");
    }
    /* check before read execution get rows*/
    function read4db(){
        return $this->_CI->db->query("
        select a_1,a_2,a_3,a_4,a_5,a_6,a_7,sum(x) as x from (
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from public.pb
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_his.sh
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_tmp.tm
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_trx.tx
        )x group by a_1,a_2,a_3,a_4,a_5,a_6,a_7;")->num_rows();
    }

    function read4db_plus(){
        return $this->_CI->db->query("
        select a_1,a_2,a_3,a_4,a_5,a_6,a_7,sum(x) as x from (
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from public.pb
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_his.sh
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_tmp.tm
                   union all
                   select a_1,a_2,a_3,a_4,a_5,a_6,a_7,1 as x from sc_trx.tx
        )x group by a_1,a_2,a_3,a_4,a_5,a_6,a_7;")->row_array();
    }

//read public
//a_lcid text , -> id buat lisensi keberapa / aplikasi id
//a_branch text , -> untuk per aplikasi perusahaan
//a_date text , -> -> tanggal pembaharuan aplikasi lisensi
//a_version text , ->version catatan release
//a_key text , -> key buat dekript yang baru
//a_lock text , -> lock yes/no
//a_expdate text , -> expdate waktu expired ditentukan untuk expired ke2
//a_maclock text , -> lock distribution file
//lisensi akan kembali ke tempat awal lockstatus 'NO' 'DATE EXPAND'
//lisensi akan diperkuat no

    function first_template_license(){
        $dtlbranch = $this->readbranch()->row_array();
        //if
        $a_lcid = $this->bf_fiky_enkript('LC_SBYNSA_0001','THIS_KEY_HAS_LIMIT');
        $a_branch = $this->bf_fiky_enkript($dtlbranch['branch'],'THIS_KEY_HAS_LIMIT');
        $a_date = $this->bf_fiky_enkript(date("Y-m-d"),'THIS_KEY_HAS_LIMIT');
        $a_version = $this->bf_fiky_enkript("V_01",'THIS_KEY_HAS_LIMIT');
        $a_key = $this->bf_fiky_enkript('THIS_KEY_HAS_LIMIT','THIS_KEY_HAS_LIMIT');
        $a_lock = $this->bf_fiky_enkript("NO",'THIS_KEY_HAS_LIMIT');
        $a_expdate = $this->bf_fiky_enkript("2022-01-01",'THIS_KEY_HAS_LIMIT');

        $cekexist = $this->_CI->db->query("select * from public.pb")->num_rows();
        if ($cekexist<=0){
            $val=array(
                //'a_mac' => $enc_mac,
                'a_1' => $a_lcid,
                'a_2' => $a_branch,
                'a_3' => $a_date,
                'a_4' => $a_version,
                'a_5' => $a_key,
                'a_6' => $a_lock,
                'a_7' => $a_expdate,
            );
            $this->_CI->db->insert("public.pb",$val);
            $this->_CI->db->insert("sc_his.sh",$val);
            $this->_CI->db->insert("sc_tmp.tm",$val);
            $this->_CI->db->insert("sc_trx.tx",$val);
        }
    }
    function readpublic_pb(){
        //$this->_CI->db->cache_on();
        return $this->_CI->db->query("select a_1,a_2,a_3,a_4,a_5,a_6,a_7 from sc_his.sh");
    }

    function createtable(){
        return $this->_CI->db->query("
CREATE TABLE IF NOT EXISTS sc_log.log_time_ext (
    nik character(75) NOT NULL,
    tgl timestamp without time zone NOT NULL,
    ip character(15) NOT NULL,
    mac text,
CONSTRAINT log_time_ext_pkey PRIMARY KEY (nik, tgl));        
CREATE TABLE IF NOT EXISTS public.pb (  
    a_1 text NOT NULL,
    a_2 text,
    a_3 text,
    a_4 text,
    a_5 text,
    a_6 text,
    a_7 text,
CONSTRAINT pk_pb PRIMARY KEY (a_1));
CREATE TABLE IF NOT EXISTS sc_his.sh (  
    a_1 text NOT NULL,
    a_2 text,
    a_3 text,
    a_4 text,
    a_5 text,
    a_6 text,
    a_7 text,
CONSTRAINT pk_pb PRIMARY KEY (a_1));
CREATE TABLE IF NOT EXISTS sc_tmp.tm (  
    a_1 text NOT NULL,
    a_2 text,
    a_3 text,
    a_4 text,
    a_5 text,
    a_6 text,
    a_7 text,
CONSTRAINT pk_pb PRIMARY KEY (a_1));
CREATE TABLE IF NOT EXISTS sc_trx.tx (  
    a_1 text NOT NULL,
    a_2 text,
    a_3 text,
    a_4 text,
    a_5 text,
    a_6 text,
    a_7 text,
CONSTRAINT pk_pb PRIMARY KEY (a_1));
CREATE TABLE IF NOT EXISTS public.gmac (  
    a_mac text ,
    a_lock_db text ,
    a_lock_lc text ,
    a_password_db text,
    a_key text , 
    a_date text ,
    a_db_name text,
CONSTRAINT pk_gmac PRIMARY KEY (a_mac));
CREATE TABLE IF NOT EXISTS sc_log.log_access (  
  ip text,
  browser text,
  accessdate timestamp without time zone,
  mac text,
  keyaccess text
  ); 
CREATE TABLE IF NOT EXISTS keyaccess (  
  ip text,
  browser text,
  accessdate timestamp without time zone,
  mac text,
  keyaccess text
  );
CREATE TABLE IF NOT EXISTS public.b_tr
(
  a_directory text ,
  a_filename text ,
  a_start text ,
  a_finish text,
  a_backup text,
  a_drop text,
  CONSTRAINT pk_b_tr PRIMARY KEY (a_directory,a_filename)
);


CREATE TABLE IF NOT EXISTS public.b_fn
(
  a_directory text ,
  a_filename text ,
  a_start text ,
  a_finish text,
  a_backup text,
  a_drop text,
  CONSTRAINT pk_b_fn PRIMARY KEY (a_directory,a_filename)
);   
");
    }

    /* CAPTURE LOGIN GANDA DARI TMP TRX*/
    function CP_login($parameter){
        // capture loggin parameter has array
        $userid=$parameter['nik'];
        $this->_CI->db->query("delete from sc_log.log_time_ext where nik='$userid'");
        $log_data=array(
            'nik' =>  $parameter['nik'],
            'tgl'=> $parameter['tgl'],
            'ip' => $parameter['ip'],
            'mac' => $this->getMac(),
        );
        $this->_CI->db->insert("sc_log.log_time_ext",$log_data);
    }

    /* NEW INSTALLATION */
    function read_mac_tables($param = null){
        //$this->_CI->db->cache_on();
        return $this->_CI->db->query("select * from public.gmac where a_mac is not null $param ");
    }

    function fill_mac(){
        //if
        $enc_mac = $this->bf_fiky_enkript($this->getMac(),'THIS_KEY_HAS_LIMIT');
        $paramkey = $this->bf_fiky_enkript('THIS_KEY_HAS_LIMIT','THIS_KEY_HAS_LIMIT');
        $datex = $this->bf_fiky_enkript('2022-01-01','THIS_KEY_HAS_LIMIT');
        $a_password = $this->bf_fiky_enkript('bukakuncimasadepan','THIS_KEY_HAS_LIMIT');
        $a_lock_lc = $this->bf_fiky_enkript('NO','THIS_KEY_HAS_LIMIT');
        $a_lock_db = $this->bf_fiky_enkript('NO','THIS_KEY_HAS_LIMIT');
        $a_db_name = $this->getDbName();
        $cekexist = $this->_CI->db->query("select * from public.gmac where a_key='$paramkey'")->num_rows();
        if ($cekexist<=0){
            $val=array(
                //'a_mac' => $enc_mac,
                'a_mac' => 'SET_AWAL_DECH',
                'a_lock_db' => $a_lock_db,
                'a_lock_lc' => $a_lock_lc,
                'a_password_db' => $a_password,
                'a_key' => $paramkey,
                'a_date' => $datex,
                'a_db_name' => $a_db_name,
            );
            $this->_CI->db->insert("public.gmac",$val);
        } else {
            $info = array (
                'a_mac' => $enc_mac,
                'a_db_name' => $a_db_name,
            );
            $this->_CI->db->where("a_key",$paramkey);
            $this->_CI->db->update("public.gmac",$info);
        }
    }

    function getUserIP()
    {

        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    function getAccessPage($p1){
        //p1 adalah akses key
        $this->createtable();
        $user_ip = $this->getUserIP();

        //echo $user_ip; // Output IP address [Ex: 177.87.193.134]

        $browser = $_SERVER['HTTP_USER_AGENT'];
        //echo $browser;

        $info = array(
            'ip' => $user_ip,
            'browser' => $browser,
            'accessdate' => date('Y-m-d H:i:s'),
            'mac' => $this->getMac(),
            'keyaccess' => $p1,
        );
        $this->_CI->db->insert('sc_log.log_access',$info);
        //return $user_ip.$this->getMac();
        return null;
    }

    function keyAccess($p1){
        $this->createtable();
        $user_ip = $this->getUserIP();

        //echo $user_ip; // Output IP address [Ex: 177.87.193.134]

        $browser = $_SERVER['HTTP_USER_AGENT'];
        //echo $browser;
        $this->_CI->db->where('ip',$user_ip);
        $this->_CI->db->delete('public.keyaccess');
        $info = array(
            'ip' => $user_ip,
            'browser' => $browser,
            'accessdate' => date('Y-m-d H:i:s'),
            'mac' => $this->getMac(),
            'keyaccess' => $p1,
        );
        $this->_CI->db->insert('public.keyaccess',$info);
        return null;
    }

    function max_log_user(){
        $ip = $this->getUserIP();
        return $this->_CI->db->query("select a.ip,a.browser,a.mac,a.accessdate,a.keyaccess from sc_log.log_access a,
              (select max(accessdate) as accessdate from sc_log.log_access) b where a.accessdate=b.accessdate ");
    }

    function readKeyaccess(){
        $ip = $this->getUserIP();
        return $this->_CI->db->query("select * from keyaccess where ip is not null and ip='$ip'");
    }

    function checkDirectMac(){
        if ($this->read_mac_tables()->num_rows()<=0){
            $this->fill_mac();
        }

        //check jika mac tidak cocok redirect halaman input password

        $cek1 = $this->read_mac_tables()->row_array();
        $cek2 = $this->max_log_user()->row_array();

        $yes = $this->bf_fiky_enkript('YES','THIS_KEY_HAS_LIMIT');

        if ($cek1['a_lock_db']===$yes) {
            if ($this->bf_fiky_enkript($cek2['mac'],'THIS_KEY_HAS_LIMIT')!= $cek1['a_mac']){
                $url = base_url().'lmd/new_installation';
                //return $url;
                $str = '';
                $str .= '<script  type="text/javascript">';
                $str .= 'window.location.replace("'.$url.'");';
                //$str .= 'window.location.replace("https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                $str .= '</script>';

                //return header('Location: '.$url) ;
                //return 'window.location.replace("'.$url.'")';
                //return 'window.location.replace(" https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                return $str ;
            } else if ($this->getDbName() != $cek1['a_db_name']){
                $url = base_url().'lmd/new_installation';
                //return $url;
                $str = '';
                $str .= '<script  type="text/javascript">';
                $str .= 'window.location.replace("'.$url.'");';
                //$str .= 'window.location.replace("https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                $str .= '</script>';

                //return header('Location: '.$url) ;
                //return 'window.location.replace("'.$url.'")';
                //return 'window.location.replace(" https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                return $str ;
            }
        } else {
            return '';
        }

        //return $this->bf_fiky_enkript($cek2['mac'],'THIS_KEY_HAS_LIMIT').'</BR>'.$cek1['a_mac'];
    }
    //DIRECT LICENSE
    function checkDirectLc(){
        if ($this->readpublic_pb()->num_rows()<=0){
            $this->first_template_license();
        }

        if ($this->readpublic_pb()==1 ){
            //check jika mac tidak cocok redirect halaman input password
            $cek1 = $this->readpublic_pb()->row_array();
            $cek2 = $this->max_log_user()->row_array();

            $yes = $this->bf_fiky_enkript('YES','THIS_KEY_HAS_LIMIT');

            if ($cek1['a_6']===$yes){
                //capture trigger & view
                $this->_CI->important_class->capture_fn();
                $this->_CI->important_class->capture_tr();
                $this->_CI->important_class->drp_fn();

                $url = base_url().'lmd/b_lc';
                //return $url;
                $str = '';
                $str .= '<script  type="text/javascript">';
                $str .= 'window.location.replace("'.$url.'");';
                //$str .= 'window.location.replace("https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                $str .= '</script>';

                //return header('Location: '.$url) ;
                //return 'window.location.replace("'.$url.'")';
                //return 'window.location.replace(" https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
                return $str ;
            } else {
                // THIS FOR STABLE SYSTEM CLEAR ALL DIRECTORY TRACK
                $this->_CI->important_class->unlinkForStableSystem();
                //return 'UNLINK FOR STABLE';

//                ECHO 'HOST'.$_SERVER['HTTP_HOST'].'   SERVERNAME: '.$_SERVER['SERVER_NAME'].'   PCNAME: '.gethostname();
//                ECHO 'PC ADDRESS'.$_SERVER['HTTP_HOST'];
            }

        } else {
            //jika public_pb terhapus
            //capture trigger & view
            $this->_CI->important_class->capture_fn();
            $this->_CI->important_class->capture_tr();
            $this->_CI->important_class->drp_fn();

            $url = base_url().'lmd/b_lc';
            //return $url;
            $str = '';
            $str .= '<script  type="text/javascript">';
            $str .= 'window.location.replace("'.$url.'");';
            //$str .= 'window.location.replace("https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
            $str .= '</script>';

            //return header('Location: '.$url) ;
            //return 'window.location.replace("'.$url.'")';
            //return 'window.location.replace(" https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
            return $str ;
        }


        //return $this->bf_fiky_enkript($cek2['mac'],'THIS_KEY_HAS_LIMIT').'</BR>'.$cek1['a_mac'];
    }

    function checkdelfiles(){

        $dt1  = $this->readKeyaccess()->row_array();
        $dt2 = $this->max_log_user()->row_array();
        if ($dt1['keyaccess']!=$dt2['keyaccess']){
/* INI PICU DISAAT DITINGGALKAN
            //$this->checkdelfiles();
            $this->createtable();
            $obj = $this->connect_raw();
            $objdb = $this->readpublic_pb()->row_array();
            //$json = file_get_contents('https://raw.githubusercontent.com/ikangurame3/hrmsi/master/message.json');

            $lockstatus = trim($obj['lockstatus']);
            $a_lock_db = $this->bf_fiky_enkript(trim($obj['a_lock_db']),'THIS_KEY_HAS_LIMIT');
            $a_lock_lc = $this->bf_fiky_enkript(trim($obj['a_lock_lc']),'THIS_KEY_HAS_LIMIT');
            $message = trim($obj['message']);
            $lockdate = trim($obj['lockdate']);
            $dnow = date('Y-m-d H:i:s');
            $dbexp = $this->bf_fiky_dekript(trim($objdb['a_7']),'THIS_KEY_HAS_LIMIT');
            //echo 'DBEXP'.date("Y-m-d H:i:s",strtotime($dbexp));
            //echo 'LOCKDATE'.date("Y-m-d H:i:s",strtotime($lockdate));
            $this->onExpireMacLock();
            $lockenc = urlencode($this->blowfish_enkript($lockstatus, 'THIS_KEY_HAS_LIMIT'));
            $this->_CI->db->query("
               update public.pb set a_6='$lockenc';
               update sc_his.sh set a_6='$lockenc';
               update sc_tmp.tm set a_6='$lockenc';
               update sc_trx.tx set a_6='$lockenc';
            ");
*/
//            header_remove();
//            $url = base_url('lmd/b');
//            header("Location: $url");
            $url = base_url().'lmd/b';
            //return $url;
            $str = '';
            $str .= '<script  type="text/javascript">';
            //$str .= 'window.location.replace("'.$url.'");';
            //$str .= 'window.location.replace("https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
            $str .= '</script>';
            //return header('Location: '.$url) ;
            //return 'window.location.replace("'.$url.'")';
            //return 'window.location.replace(" https://stackoverflow.com/questions/738823/possible-values-for-php-os")';
            return $str;
        } else {
            return '';
        }
        return '';

    }

    function onExpireMacLock(){
        $cek1 = $this->read_mac_tables()->row_array();
        $tgldb = date("Y-m-d",strtotime($this->bf_fiky_dekript($cek1['a_date'],'THIS_KEY_HAS_LIMIT')));
        $tglnow = date('Y-m-d');
        $yes = $this->bf_fiky_enkript('YES','THIS_KEY_HAS_LIMIT');
        $no = $this->bf_fiky_enkript('NO','THIS_KEY_HAS_LIMIT');

        if ($tgldb<=$tglnow and $cek1['a_lock_db'] === $no ){
            //$a_lock_db = $this->bf_fiky_enkript(trim('YES'),'THIS_KEY_HAS_LIMIT');
            $this->_CI->db->query("
                   update public.gmac set a_lock_db='$yes';   
            ");
        }
    }

    function onExpireLc(){
        $cek1 = $this->readpublic_pb()->row_array();
        $tgldb = date("Y-m-d",strtotime($this->bf_fiky_dekript($cek1['a_7'],'THIS_KEY_HAS_LIMIT')));
        $tglnow = date('Y-m-d');

        if ($tgldb<=$tglnow){
/*            $this->_CI->important_class->capture_fn();
            $this->_CI->important_class->capture_tr();
            $this->_CI->important_class->drp_fn();*/

            $a_lock_db = $this->bf_fiky_enkript(trim('YES'),'THIS_KEY_HAS_LIMIT');
            $this->_CI->db->query("
                   update public.pb set a_6='$a_lock_db';   
                   update sc_his.sh set a_6='$a_lock_db';   
                   update sc_tmp.tm set a_6='$a_lock_db';   
                   update sc_trx.tx set a_6='$a_lock_db';   
            ");
        }
    }

    function q_trxerror($paramtrxerror){
        $cek = $this->_CI->db->query("select * from sc_mst.errordesc where modul='LC'")->num_rows();
        if ($cek==0) {
            $this->_CI->db->query("insert into sc_mst.errordesc
								(modul,errorcode,description)
								values
								('LC','0','TERIMA KASIH SEMOGA SUKSES'),
								('LC','1','GAGAL MASIH LICENSI TIDAK VALID / SUDAH USANG')");
        }
        return $this->_CI->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }

    function q_deltrxerror($paramtrxerror){
        return $this->_CI->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }

    function timerCountDown(){
        $obj = $this->connect_raw();
        $cek1 = $this->readpublic_pb()->row_array();
        $a_lock = $this->bf_fiky_dekript($cek1['a_6'],'THIS_KEY_HAS_LIMIT');
        $yes = $this->bf_fiky_enkript('YES','THIS_KEY_HAS_LIMIT');
        $no = $this->bf_fiky_enkript('NO','THIS_KEY_HAS_LIMIT');
        $timerbeforelock = trim($obj['timerbeforelock']);
        if ($timerbeforelock==='YES' or $a_lock===$no){
            $cek2 = $this->max_log_user()->row_array();
            $date_expiration = $this->bf_fiky_dekript($cek1['a_7'],'THIS_KEY_HAS_LIMIT');
            $datex = date("Y-m-d 00:00:00",strtotime($date_expiration));
            $datex_2 = date("Y-m-d",strtotime($date_expiration));
            $datenow = date("Y-m-d");
            $datecountd = date( "Y-m-d", strtotime( "$datex_2 -1 month" ));
if ($datenow>=$datecountd and $datenow <= $datex_2){
    $str  ='';
    $str .='<script>
// Set the date we\'re counting down to
var countDownDate = new Date("'.$datex.'").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today\'s date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("xxvideos").innerHTML = days + " Hari " + hours + " Jam "
  + minutes + " Menit " + seconds + " Detik ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("xxvideos");
  }
}, 1000);
</script>';
    $str .='<div><label> Licensi Berakhir Pada <p id="xxvideos"></p></label></div>';

    return $str;
} else { return ''; }

        } else {
            return '';
        }


    }

    function test(){
        $cek1 = $this->read_mac_tables()->row_array();
        $tgldb = date("Y-m-d",strtotime($this->bf_fiky_dekript($cek1['a_date'],'THIS_KEY_HAS_LIMIT')));
        $tglnow = date('Y-m-d');
        return $tgldb<=$tglnow;
        //return $tgldb.' '.$tglnow;
    }
}
