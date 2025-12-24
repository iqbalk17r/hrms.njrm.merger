<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mailer extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('payroll/m_final', 'mail/m_mailserver','Api/m_setup','Api/m_cabang'));
        $this->load->library(array('Fiky_encryption', 'Fiky_mailer', 'pdfs'));
    }

    function index()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }

    function capitalize($str)
    {
        $words = explode(' ', $str);
        $capitalized = array_map('ucfirst', array_map('strtolower', $words));
        return implode(' ', $capitalized);
    }

    function formatIDR($number)
    {
        return number_format($number, 0, ',', '.');
    }


    function send_mail_jagoan($title = 'Judul', $mailto = '4mailbot@gmail.com,bagoswahyus486@gmail.com,fornubi2020@gmail.com',$message='<h1>Important message use this as tester</h1>', $attachment = null)
    {
        $this->load->library(array('jagoan_mail'));
        $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
        $dari = $sender['primarymail'];
        $subject = $title;
        $this->jagoan_mail->clear(false)
            ->setTo(explode(",", $mailto))
            ->setFrom($sender['primarymail'])
            ->setFromName('PT SINAR NUSANTARA INDUSTRIES')
            ->setSubject($subject)
            ->setMessage($message);
//            ->addAttachment('assets/attachment/pdf_payroll/Slip Gaji.pdf');
        if ($this->jagoan_mail->buildAndSend()) {
            return true;
        } else {
            echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
        }
    }

     function send_mail_agenda($referenceid)
    {
            $this->load->model(array('agenda/M_Notifications'));
            $message = array();
            if (!is_null($referenceid)){
                $filter = ' AND reference_id = \''.$referenceid.'\' ';
            }else{
                var_dump('reference_id is null');
                exit;
            }

            foreach ($this->M_Notifications->read((isset($filter) ? $filter : '').'  AND status is null AND type = \'email\' '.(isset($limit) ? $limit : ''))->result() as $index => $item) {
                $this->load->library(array('jagoan_mail'));
                $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
                $dari = $sender['primarymail'];
                $subject = $this->db->select('agenda_name')
                    ->from('sc_trx.agenda')
                    ->where('agenda_id', $item->reference_id)
                    ->get()->row()->agenda_name;
                $this->jagoan_mail->clear(false)
                    ->setTo($item->email)
                    ->setFrom($dari)
                    ->setFromName('PT NUSA UNGGUL SARANA ADICIPTA')
                    ->setSubject($subject)
                    ->setMessage($item->content);
        
                    if ($this->jagoan_mail->buildAndSend()) {
                        $this->M_Notifications->update(array(
                                'status' => 'send_to_email',
                            ), array(
                                'notification_id' => $item->notification_id
                            ));
                        echo 'Mailer success: ' . $item->email;

                    } else {
                        echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
                    }
                }
            return true;
    }

    function send_cancel_mail_agenda($referenceid)
    {
        $this->load->model(array('master/M_Employee', 'trans/M_TrxType', 'agenda/M_Agenda', 'agenda/M_AgendaAttendance'));
        $this->load->library(array('jagoan_mail'));

        if (!is_null($referenceid)){
            $filter = ' AND reference_id = \''.$referenceid.'\' ';
        }else{
            var_dump('reference_id is null');
            exit;
        }

        $transaction = $this->M_Agenda->read(' AND agenda_id = \'' . $referenceid . '\' ')->row();
               
        foreach ($this->M_AgendaAttendance->read(' AND agenda_id = \''.$transaction->agenda_id.'\' ')->result() as $index => $item) {
             $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
                $dari = $sender['primarymail'];
                $subject = 'Agenda Dibatalkan:' . $transaction->agenda_name;
                $this->jagoan_mail->clear(false)
                    ->setTo($item->email)
                    ->setFrom($dari)
                    ->setFromName('PT NUSA UNGGUL SARANA ADICIPTA')
                    ->setSubject($subject)
                    ->setMessage($this->message($transaction, $item->nmlengkap));
        
                    if ($this->jagoan_mail->buildAndSend()) {
                        echo 'Mailer success: ' . $item->email;

                    } else {
                        echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
                    }
        }
            return true;
    }

    public function message($transaction, $send_to){
                $message = "
            <!DOCTYPE html>
            <html lang=\"id\">
            <head>
            <meta charset=\"UTF-8\">
            <title>Pemberitahuan Pembatalan Agenda</title>
            </head>
            <body style=\"font-family: 'Times New Roman', serif; color: #212529; margin: 0; padding: 20px;\">
            <p style=\"margin-bottom: 0;\">Yang Terhormat,</p>
            <blockquote style=\"margin-top: 5px; margin-bottom: 20px; font-family: 'Times New Roman', serif;\">$send_to</blockquote>

            <div style=\"max-width: 600px; background-color: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0;\">
                <h2 style=\"color: #dc3545; margin-top: 0;\">Pemberitahuan</h2>
                <div style=\"margin-top: 20px; line-height: 1.6;\">
                <p><strong>Nama Agenda:</strong> $transaction->agenda_name</p>
                <p><strong>Status:</strong> <span style=\"color: #dc3545;\">DIBATALKAN</span></p>
                <p><strong>Alasan Pembatalan:</strong><br>$transaction->cancel_reason</p>
                </div>

                <p style=\"margin-top: 30px;\">Demikian informasi ini kami sampaikan. Atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.</p>

                <div style=\"margin-top: 30px; font-size: 0.95em;\">
                <p style=\"margin: 0;\">--<br><strong>Best Regards,</strong></p>
                <p style=\"margin: 5px 0 0 0;\">
                    PT. Nusa Unggul Sarana Adicipta<br>
                    Jl. Margomulyo Indah II Blok A No. 15 Surabaya - Jawa Timur<br>
                    Phone: 0896 2694 1650 | Telp: (031) 7491856-58<br>
                    Email: <a href=\"mailto:odtraining.nusa@nusantarajaya.co.id\" style=\"color: #0d6efd; text-decoration: none;\">odtraining.nusa@nusantarajaya.co.id</a>
                </p>
                </div>
            </div>
            </body>
            </html>";


        return $message;
    }
    

}



    



