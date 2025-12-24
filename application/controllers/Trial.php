<?php

class Trial extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        var_dump('ssss');
    }

    public function test($text, $is)
    {
        $this->load->library(array('generatepassword'));
        $vc_jwb = 'G?BEGD05432.164';
        $vl_dcd = ($is == 'false'); // Set to true or false based on your requirements
        $result = $this->generatepassword->sidia($vc_jwb,$vl_dcd);
        echo $result;
    }

    public function exportfile()
    {
        $this->load->view("stimulsoft/export_file",array(
            'filename' => 'laporan sales',
            'mrt'=>'assets/mrt/sales_target.mrt',
            'jsonfile'=>'automation/SalesReport/jsontest'
        ));
    }

    public function jsontest()
    {
        header('Content-Type: application/json');
        echo json_encode(array(
            'sales' => array('nama'=>'tarjo'),

        ),  JSON_PRETTY_PRINT );
    }

    public function getGreeing()
    {
        $this->load->library('greeting');
        $greeting = $this->greeting->getgreeting();
        var_dump($greeting);die();
    }

	function send_mail()
    {	
		
		$this->load->library(array('Fiky_encryption', 'Fiky_mailer', 'jagoan_mail'));
		$pass = 'vhvXD3c0FNakdLXqmzXDP5QhN42u29BEu+7va1T8lxKByzHgRc29pONMZ9iCX+ymZjiUsbEG6DigSylkM4Gqow==';
		$decode = $this->encrypt->decode($pass);
		var_dump($decode);die();
        $no_dok='NSANBI';
        $sender=$this->m_mailserver->q_smtp($no_dok)->row_array();
        //$penerima='ikangurame3@gmail.com';
        //$penerima = 'ikangurame3@gmail.com,gilrandyseptiansyah@gmail.com,jerryhadityawan@gmail.com,si_cempe@yahoo.com,si.cempe@gmail.com ';
        $penerima = 'itsbombking@gmail.com,4mailbot@gmail.com';
		$pass = 'vhvXD3c0FNakdLXqmzXDP5QhN42u29BEu+7va1T8lxKByzHgRc29pONMZ9iCX+ymZjiUsbEG6DigSylkM4Gqow==';
		
        $data = '';
        $this->jagoan_mail->clear(false)
            ->setTo(explode(",",$penerima))
            ->setCc($this->input->post('cc'))
            ->setBcc($this->input->post('bcc'))
            ->setFrom($sender['primarymail'])
            ->setFromName('PT NUSA UNGGUL SARANA ADICIPTA')
            ->setSubject('TEST SLIP GAJI')
            ->setMessage('test')
            //->setMessage(file_get_contents(base_url('/validatorMailer/validate_links')))
            ->addAttachment('assets/attachment/pdf_payroll/Slip Gaji.pdf');
        var_dump($this->jagoan_mail->getJagoan());die();
        if ($this->jagoan_mail->buildAndSend()) {
            echo 'Email sent.';
        } else {
            echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
        }


    }

    function imageToBase64($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }

        $imageData = file_get_contents($filePath);
        $mimeType  = mime_content_type($filePath);

        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }

    public function convertlogo()
    {
        echo $this->imageToBase64(FCPATH . 'assets/img/Logo_nusantara.png');
        //data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEMAAAAoCAMAAACSJ7fYAAAAh1BMVEVHcEwBYEskbU4BYEsCYUwDYk0BYEsFY04DYU0BYEsFYk0CYUwBYEsBYEsIZFADYU0CYUwCYEsBYEwCYUwDYU0CYUwDYk0DYUwCYUwBYEsCYUwCYUwDYk0jbnHXrgXWrQLWrACZnizWrAHWrAHWrAHWrQLarwXWrAHXrQLWrQLXrQMBYEvWrADzsqbJAAAAK3RSTlMA/AP2nTLhER/vGLfp0AlIhXrFXFJyOyWq2pBnKQERNusC1Iu9bQmkRVogatl0KQAAAzNJREFUSMftVdlyqzgQldAOYhU7eCFekrjz/993W3ijcquCM1M1T9MPGPk0Ry2pzxEhf4V2+SCC+2g6P4CwXAI/xORiBtRmah5tT+/Hw+6KpIUHerXOURqYgyee4v0LY/85U9gF8GOo4poJLMWaTl9zvF0ISaI7UK5x1LcyAHpCzscrxxcWIh4AX+NI6T21Dcj27cZxQoDd/qfR2rbW91Qo1LOOjyXANyscYXxPZQMhn1eK43axUdStnot7zCdrcj7s/ZbulkC0frhBZedFtxS6kkwfh8PpsgAgal5osrlDeJL0FEw/fgda9QoFCVowNTbE0OF6eKmDb8BLkYHU/rfJOjxp2brwG/ALDq+y3qsnrsLfcnAw4tn8Kce9jMvgO/BjCImNvujFjeAGGOq1lq8obu5232Xspn1yvuwuJPD/RbkHKA9foLhJvJ8n3B33+7fTmegWHjpareQp8dRTXEV3mEh4b3Wgq9oXS+2T96te9tjsA/xL7X8ugV9oH6db+sc/0b6X+LRYy9MUhtVzGZYS3+3ve0pIRV/WfnLT/lXiH8f91/6wnYHMzMD4Qo9tRM778j7ZdvdxmW6yrRFwivwf/0Vo9EvVJButJzLNgzoVXppqxCMINEo9bALV+FA49vaKo3G22aSZnSCSJcltqYoiJP4hCkYNOk3ATb9BucYiaLtmMNZaM5C669DJBhzIDCdytvAkMXRND051aJUhPlqI+gJtbLTQaaIlRGHBhIst2Niho0JOSA5dYdEc0ChmJ0AZcD5zhJ6jiYCnI04xUImSQQ6aF0ZMSQ55EqjYMLyHc8g0R90Ia6lXYAyMySdHWOJXXZ4kkalYu9GSUmO9E1e+gJTyltXIYTqGV00FWeGdPjY9qswlMSaOtgvJOHBL09FYbqQOZccBHhw9RBFkfi0Ssg0upY0B9R2zGrMcwm3ZojeUrUsjcBWWx8AhhygeHKEvGmKVQ1XSKBGG4hC9KmZCe7LGG2YxBkhIIRYRG0QFrZadSs2VoyL4YV0XLMX3IKJlDlykUo5kyENSZ6O/GdsMBa8HHvUiqSpFVD6oakgChylEZALz8LpNM+HfRZaW/jOX6z+NynL5jqy7SgAAAABJRU5ErkJggg==
    }
}
?>
