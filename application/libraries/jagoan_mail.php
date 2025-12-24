<?php
require_once dirname(__FILE__) . '/JagoanMailer/JagoanMailerAutoload.php';

class Jagoan_mail
{
    protected $_CI;
    protected $jagoan;
    public $ErrorInfo;

    function __construct()
    {
        $this->_CI =& get_instance();
        $this->_CI->load->library(array('encrypt', 'fiky_encryption'));
    }

    public function clear($debug=true)
    {
		
        $this->jagoan = new PHPMailer;
        $smtp = $this->_CI->db->query("select * from sc_mst.setup_mail_smtp where no_dok='NSANBI'")->row();
        $this->jagoan->SMTPDebug = $debug;
        $this->jagoan->isSMTP();
        $this->jagoan->SMTPAuth = true;
        $this->jagoan->Host = trim($smtp->smtp_host);
        $this->jagoan->Port = trim($smtp->smtp_port);
        $this->jagoan->SMTPSecure = 'tls';
        $this->jagoan->Username = trim($smtp->smtp_user);
        $this->jagoan->Password = $this->_CI->encrypt->decode($smtp->smtp_pass);
        $this->jagoan->From = trim($smtp->primarymail);
        $this->jagoan->FromName = trim($smtp->primarymail);

        $this->jagoan->isHTML(true);
        $this->jagoan->ClearAddresses();
        $this->jagoan->ClearCCs();
        $this->jagoan->ClearBCCs();
        return $this;
    }

    public function setTo($to)
    {
        if (is_array($to)) {
            foreach ($to as $key => $value) {
                $this->jagoan->addAddress($value);
            }
        } else {
            $this->jagoan->addAddress($to);
        }
        return $this;
    }

    public function setSubject($subject)
    {
        $this->jagoan->Subject = $subject;
        return $this;
    }

    public function setMessage($message)
    {
        $this->jagoan->Body = $message;
        $this->jagoan->AltBody = $message;
        return $this;
    }

    public function setFromName($from_name)
    {
        $this->jagoan->FromName = (empty($from_name)) ? 'Jagoan Mailer IT. Nusantara Group' : $from_name;
        return $this;
    }

    public function setFrom($from)
    {
        $this->jagoan->From = (empty($from)) ? 'noreply@nusantarajaya.co.id' : $from;
        return $this;
    }

    public function setCc($cc)
    {
        if (!empty($cc)) {
            if (is_array($cc)) {
                foreach ($cc as $key => $value) {
                    $this->jagoan->addCC($value);
                }
            } else {
                $this->jagoan->addCC($cc);
            }
        }
        return $this;
    }

    public function setBcc($bcc)
    {
        if (!empty($bcc)) {
            if (is_array($bcc)) {
                foreach ($bcc as $key => $value) {
                    $this->jagoan->addBCC($value);
                }
            } else {
                $this->jagoan->addBCC($bcc);
            }
        }
        return $this;
    }

    public function addAttachment($path, $name, $encoding, $type)
    {
        $this->jagoan->addAttachment($path, $name, $encoding, $type);
        return $this;
    }

    public function buildAndSend()
    {
        $this->ErrorInfo = null;
        if (!$this->jagoan->send()) {
            $this->ErrorInfo = $this->jagoan->ErrorInfo;
            return false;
        }
        return true;
    }

    public function getJagoan() {
        return $this->jagoan;
    }

    public function sendr($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug = 0) {
        $this->clear(true);
    }
    public function send($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug = 0)
    {
        $no_dok = 'NSANBI';
        $config_smtp = $this->_CI->db->query("select * from sc_mst.setup_mail_smtp where no_dok='$no_dok'")->row_array();
        $mail = new PHPMailer;
        $mail->SMTPDebug = $debug; // Ubah menjadi true jika ingin menampilkan sistem debug SMTP Mailer
        $mail->isSMTP();

        $mail->ClearAddresses();
        $mail->ClearCCs();
        $mail->ClearBCCs();

        $mail->SMTPAuth = true;
        $mail->Host = trim($config_smtp['smtp_host']);  // Masukkan Server SMTP
        $mail->Port = trim($config_smtp['smtp_port']);                                     // Masukkan Port SMTP
        $mail->SMTPSecure = 'tls';                                    // Masukkan Pilihan Enkripsi ( `tls` atau `ssl` )
        $mail->Username = trim($config_smtp['smtp_user']);            // Masukkan Email yang digunakan selama proses pengiriman email via SMTP
        $mail->Password = $this->_CI->encrypt->decode($config_smtp['smtp_pass']);                                      // Masukkan Password dari Email tsb
        $default_email_from = trim($config_smtp['primarymail']);         // Masukkan default from pada email
        $default_email_from_name = '';           // Masukkan default nama dari from pada email


        if (empty($from)) $mail->From = $default_email_from;
        else $mail->From = $from;

        if (empty($from_name)) $mail->FromName = $default_email_from_name;
        else $mail->FromName = $from_name;

        // Set penerima email
        if (is_array($to)) {
            foreach ($to as $k => $v) {
                $mail->addAddress($v);
            }
        } else {
            $mail->addAddress($to);
        }

        // Set email CC ( optional )
        if (!empty($cc)) {
            if (is_array($cc)) {
                foreach ($cc as $k => $v) {
                    $mail->addCC($v);
                }
            } else {
                $mail->addCC($cc);
            }
        }

        // Set email BCC ( optional )
        if (!empty($bcc)) {
            if (is_array($bcc)) {
                foreach ($bcc as $k => $v) {
                    $mail->addBCC($v);
                }
            } else {
                $mail->addBCC($bcc);
            }
        }

        // Set isi dari email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;
        $is_send = $mail->send();
        //echo $is_send;

        if (!$is_send) {
            return 1;
        } else
            return 0;
    }
}

