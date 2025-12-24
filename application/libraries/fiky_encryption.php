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
        /* Nulled by request */
        return '';
    }
    function sw_lc(){
        /* Nulled by request */
        return '';}

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
        return;
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
        /* CEK JIKA NAMA DATABASE DIRUBAH PROSES LOCKING AKTIF */
        /* Return Null By Request*/
        $salt = "THIS_KEY_HAS_LIMIT";
        $dtl = $this->_CI->db->query("SELECT current_database() as dbname")->row_array();

        return '';
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

    function codeigniter_environment()
    {
        /*Enviroment Ter Ubah */
        /* Nulled By Request */
        return '';
    }

    /* check branch*/
    function readbranch(){
        /* Pembacaan Branch Untuk KEY */
        return $this->_CI->db->query("
                   select * from sc_mst.branch where cdefault='YES'");
    }
    /* check before read execution get rows*/
    function read4db(){
        /* Off Jika nama data salah 1 db terubah dari ke 4 list yang sama*/
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
        /* Off Jika nama data salah 1 db terubah dari ke 4 list yang sama*/
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


    function first_template_license(){
        /* Definisi awal database * Pembacaan Expired Ke Enkripsi Tabel */
        $dtlbranch = $this->readbranch()->row_array();
        /* Nulled By Request */
    }
    function readpublic_pb(){
        //$this->_CI->db->cache_on();
        return $this->_CI->db->query("select a_1,a_2,a_3,a_4,a_5,a_6,a_7 from sc_his.sh");
    }

    function createtable(){
        return null;
        /* Create tabel data */
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
        // table public.gmac
        /* Nulled by request */
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
        /* INI PICU TIDAK ADA KESESUAIAN DATA */
        /* Nulled by request */
        return '';


    }
    //DIRECT LICENSE
    function checkDirectLc(){
        /* INI PICU TIDAK ADA KESESUAIAN DATA */
        /* Nulled by request */
        return '' ;


    }

    function checkdelfiles(){
        /* INI PICU DISAAT SALAH 1 TERHAPUS */
        /* Nulled by request */
        return '' ;

    }

    function onExpireMacLock(){
        /* INI MAC ADDRES KADALUARSA */
        /* Nulled by request */
        return '' ;
    }

    function onExpireLc(){
        /* INI LISENSI ADDRES KADALUARSA */
        /* Nulled by request */
        return '' ;
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
     /* TIMER NOTIFICATION */
        /* Nulled by request*/
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

            return '';

    }

    function test(){
        /* Nulled by request */
    }
}
