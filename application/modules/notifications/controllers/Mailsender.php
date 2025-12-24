<?php

class Mailsender extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('jagoan_mail'));
    }
    public function send()
    {
        $this->load->model(array('agenda/M_Notifications','master/M_Employee','mail/m_mailserver'));
        $this->load->helper(array('generate'));
        $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
        $dari = $sender['primarymail'];
        foreach ($this->M_Notifications->read(' AND status IS NULL AND type = \'email\' LIMIT 1')->result() as $index => $item) {
            $employee = $this->M_Employee->read(' AND nik = \''.$item->send_to.'\' ')->row();
            // vdump($item->content);
            $this->jagoan_mail->clear(true, 'NSANBI')
                ->setFrom($sender['primarymail'])
                ->setTo(trim($employee->email))
                // ->setTo(trim('4mailbot@gmail.com'))
                ->setSubject(!empty($item->subject) ? $item->subject : 'FOR TRIAL ONLY')
                // ->setFromName('noreply_hrga@nusantarajaya.co.id')
                ->setMessage($item->content);
            if ($this->jagoan_mail->buildAndSend()) {
                $this->M_Notifications->update(array(
                    'status' => 'send_to_mail'
                ),array(
                    'notification_id' => $item->notification_id,
                    'reference_id' => $item->reference_id,
                    'type' => $item->type,
                ));
            }else{
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($this->jagoan_mail->ErrorInfo);
            }
        }
    }

    public function test_mail($email = 'iqbalkresna.12@gmail.com'){
        $this->jagoan_mail->sendr(
            '4mailbot@gmail.com', 
            $subject, 
            'TEST', 
            $from_name, 
            $from, 
            $cc, 
            $bcc, 
            $debug = 1
        );
    }
}