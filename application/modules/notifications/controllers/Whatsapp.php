<?php



class Whatsapp extends MX_Controller
{
    public function shuffle($len = 4)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charcode = '';
        for ($loop = 0; $loop < $len; $loop++) {
            $charcode .= str_shuffle($chars)[0];
        }
        return $charcode;
    }
    public function auth($branch)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getBaseUrl($branch) . 'api/token/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('user_name' => $this->getBotUser($branch), 'password' => $this->getBotPassword($branch)),
        ));
        
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                $this->setTokenAccess($branch,$body->access);
                $this->setTokenRefresh($branch,$body->refresh);
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
        }
    }

    public function refresh($branch)
    {
        $refresh = $this->getTokenRefresh($branch);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getBaseUrl($branch) . 'api/token/refresh/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('refresh' => $refresh),
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                $this->setTokenAccess($branch,$body->access);
                $this->setTokenRefresh($branch,$body->refresh);
            }
        }
    }

    public function send($branch = 'SBYNSA', $referenceid)
    {
        $this->load->model(array('master/M_Option', 'agenda/M_Notifications'));
        $message = array();
        if (!is_null($referenceid)){
            $filter = ' AND reference_id = \''.$referenceid.'\' ';
        }else{
            $limit = ' LIMIT ' . $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-SEND-LIMIT:SBYNSA\'  ')->row()->value1;
        }

        foreach ($this->M_Notifications->read((isset($filter) ? $filter : '').'  AND status is null AND type = \'wa\' '.(isset($limit) ? $limit : ''))->result() as $index => $item) {
            $ref = $this->shuffle();
            if ((strlen($item->phone) > 7) OR $item->phone <> '000000000000' ){
                $outbox_fors = explode(',', $item->phone);
                // $outbox_fors = explode(',', '6287826765051');
                foreach ($outbox_fors as $index => $outbox_for) {
                    if (substr($outbox_for, 0, 2) === '08') {
                        $outbox_for = '628' . substr($outbox_for, 2, strlen($outbox_for)); //.'@s.whatsapp.net';
                        $outbox_fors[$index] = $outbox_for;
                    }
                }
                $sessionSetup = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-SESSION:SBYNSA\'  ')->row()->value1;
                $agreeText = $item->agree_text;
                $disagreeText = $item->disagree_text;
                if ($item->is_interactive=='t'){
                    $messageText = $item->content.PHP_EOL.PHP_EOL
                        . '_Balas:_' . PHP_EOL
                        . '_Ya = '.$agreeText.', Tidak = '.$disagreeText.'_' . PHP_EOL . PHP_EOL
                        . '_Ref:' . $ref . '_';
                }else{
                    $messageText = $item->content.PHP_EOL.PHP_EOL
                    . '_Ref:' . $ref . '_';
                }
                array_push($message, array(
                    'message' => $messageText,
                    'message_type' => "conversation",
                    'outbox_for' => implode(',', $outbox_fors).'@s.whatsapp.net',
                    'is_interactive' => ($item->is_interactive == 't' ? TRUE : FALSE),
                    'retry' => 1,
                    'session' => $sessionSetup,
                    'properties' => array(
                        'id' => $item->notification_id,
                        'objectid' => $item->reference_id,
                        'employeeid' => $item->send_to,
                        'type' => json_decode($item->properties,true)['type'],
                    )
                ));
            }
        }
//        var_dump($message);die();
        $access = $this->getTokenAccess($branch);
        if (count($message) > 0) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->getBaseUrl($branch) . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($message),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $access,
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->M_Notifications->update(array(
                            'status' => 'send_to_wa',
                        ), array(
                            'notification_id' => $row->properties->id
                        ));
                    }
                }else{
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                }
            }else{
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ),
                    JSON_PRETTY_PRINT
                );
            }
        }else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }


    }

    public function handle($branch=null, $referenceid = null)
    {
        $this->load->model(array('master/M_Branch'));
        if (is_null($branch)) {
            foreach ($this->M_Branch->read()->result() as $index => $row) {
                if ($this->send($row->branch, $referenceid)) {
                } else {
                    if ($this->refresh($row->branch, $referenceid)) {
                        $this->handle($row->branch, $referenceid);
                    } else {
                        if ($this->auth($row->branch, $referenceid)) {
                            $this->handle($row->branch, $referenceid);
                        }
                    }
                }
            }
        } else {
            if ($this->send($branch, $referenceid)) {
            } else {
                if ($this->refresh($branch, $referenceid)) {
                    $this->handle($branch, $referenceid);
                } else {
                    if ($this->auth($branch, $referenceid)) {
                        $this->handle($branch, $referenceid);
                    }
                }
            }
        }
    }

    public function directsend($branch = 'SBYNSA',$referenceid)
    {
        $this->load->model(array('master/M_Option', 'agenda/M_Notifications'));
        $message = [];
        foreach ($this->M_Notifications->read(' AND status is null  AND reference_id = \''.$referenceid.'\'  AND type = \'wa\' LIMIT ' . $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-SEND-LIMIT:SBYNSA\'  ')->row()->value1)->result() as $index => $item) {
            if ((strlen($item->phone) > 7) OR $item->phone <> '000000000000' ){
                $outbox_fors = explode(',', $item->phone);
                // $outbox_fors = explode(',', '6287826765051');
                foreach ($outbox_fors as $index => $outbox_for) {
                    if (substr($outbox_for, 0, 2) === '08') {
                        $outbox_for = '628' . substr($outbox_for, 2, strlen($outbox_for)); //.'@s.whatsapp.net';
                        $outbox_fors[$index] = $outbox_for;
                    }
                }
                $sessionSetup = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-SESSION:SBYNSA\'  ')->row()->value1;
                array_push($message, array(
                    'message' => $item->content,
                    'message_type' => "conversation",
                    'outbox_for' => implode(',', $outbox_fors).'@s.whatsapp.net',
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $sessionSetup,
                    'properties' => array(
                        'id' => $item->notification_id,
                        'ticket' => $item->ticket_id,
                    )
                ));
            }
        }

        // var_dump($message);die();

        $access = $this->getTokenAccess($branch);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getBaseUrl($branch) . 'whatsapp/api/outbox/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($message),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 201) {
                foreach ($body as $row) {
                    $this->M_Notifications->update(array(
                        'status' => 'send_to_wa',
                    ), array(
                        'notification_id' => $row->properties->id
                    ));
                }
            }
        }
    }

    public function handledirectsend($branch=null,$documentid)
    {
        $this->load->model(array('master/M_Branch'));
        if (is_null($branch)) {
            foreach ($this->M_Branch->read()->result() as $index => $row) {
                if ($this->directsend($row->branch, $documentid)) {
                } else {
                    if ($this->refresh($row->branch)) {
                        $this->directsend($row->branch, $documentid);
                    } else {
                        if ($this->auth($row->branch)) {
                            $this->directsend($row->branch, $documentid);
                        }
                    }
                }
            }
        } else {
            if ($this->directsend($branch)) {
            } else {
                if ($this->refresh($branch)) {
                    $this->directsend($branch, $documentid);
                } else {
                    if ($this->auth($branch)) {
                        $this->directsend($branch, $documentid);
                    }
                }
            }
        }
    }

    public function getBaseUrl($branch)
    {
        $this->load->model('master/M_Option');
        if (!$this->M_Option->q_transaction_exists(array('kdoption'=>'WABOT:BASEURL'))) {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_create(array(
                    'kdoption' => 'WABOT:BASEURL',
                    'nmoption' => 'BASEURL API WA BOT',
                    'value1' => 'https://localhost:8888/',
                    'status' => 'T',
                    'group_option' => 'WABOT',
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s')
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:BASEURL\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        } else {
            $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:BASEURL\'  ')->row();
        }
        return $config->value1;
    }

    public function getBotUser($branch='')
    {
        $this->load->model('master/M_Option');
        if (!$this->M_Option->q_transaction_exists(array('kdoption'=>'WABOT:USER'))) {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_create(array(
                    'kdoption' => 'WABOT:USER',
                    'nmoption' => 'USER LOGIN WA BOT',
                    'value1' => 'root',
                    'status' => 'T',
                    'group_option' => 'WABOT',
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s')
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:USER\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        } else {
            $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:USER\'  ')->row();
        }

        return $config->value1;
    }

    public function getBotPassword($branch='')
    {
        $this->load->model('master/M_Option');
        if (!$this->M_Option->q_transaction_exists(array('kdoption'=>'WABOT:PASSWORD'))) {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_create(array(
                    'kdoption' => 'WABOT:PASSWORD',
                    'nmoption' => 'USER LOGIN WA BOT',
                    'value1' => '#Admin#',
                    'status' => 'T',
                    'group_option' => 'WABOT',
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s')
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:PASSWORD\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        } else {
            $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WABOT:PASSWORD\'  ')->row();
        }

        return $config->value1;
    }

    public function setTokenAccess($branch,$token)
    {
        $this->load->model('master/M_Option');
        if (!$this->M_Option->q_transaction_exists(array('kdoption'=>'WA-ACCESS:SBYNSA'))) {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_create(array(
                    'kdoption' => 'WA-ACCESS:SBYNSA',
                    'nmoption' => 'TOKEN ACCESS WA BOT',
                    'value1' => $token,
                    'status' => 'T',
                    'group_option' => 'WA',
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s')
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-ACCESS:SBYNSA\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        } else {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_update(array(
                    'value1' => $token,
                    'update_by' => 'SYSTEM',
                    'update_date' => date('Y-m-d H:i:s')
                ), array(
                    'kdoption' => 'WA-ACCESS:SBYNSA',
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-ACCESS:SBYNSA\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        }
        return $config->value1;
    }

    public function setTokenRefresh($branch,$token)
    {
        $this->load->model('master/M_Option');
        if (!$this->M_Option->q_transaction_exists(array('kdoption'=>'WA-REFRESH:SBYNSA'))) {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_create(array(
                    'kdoption' => 'WA-REFRESH:SBYNSA',
                    'nmoption' => 'TOKEN REFRESH WA BOT',
                    'value1' => $token,
                    'status' => 'T',
                    'group_option' => 'WA',
                    'input_by' => 'SYSTEM',
                    'input_date' => date('Y-m-d H:i:s')
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-REFRESH:SBYNSA\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        } else {
            try {
                $this->db->trans_start();
                $this->M_Option->q_transaction_update(array(
                    'value1' => $token,
                    'update_by' => 'SYSTEM',
                    'update_date' => date('Y-m-d H:i:s')
                ), array(
                    'kdoption' => 'WA-REFRESH:SBYNSA',
                ));
                $this->db->trans_complete();
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $config = $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-REFRESH:SBYNSA\'  ')->row();
                } else {
                    throw new Exception("Error DB", 1);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
            }
        }
        return $config->value1;
    }

    public function getTokenAccess($branch)
    {
        $this->load->model('master/M_Option');
        return $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-ACCESS:SBYNSA\'  ')->row()->value1;
    }

    public function getTokenRefresh($branch)
    {
        $this->load->model('master/M_Option');
        return $this->M_Option->q_transaction_read_where(' AND kdoption = \'WA-REFRESH:SBYNSA\'  ')->row()->value1;
    }

}