<?php

class M_token_google extends CI_Model
{
   public function get_token_credential(){
    $query = $this->db->query("select trim(kdoption) as kdoption, trim(value1) as value1 
                                from sc_mst.option 
                                 where trim(group_option) = 'GOOGLE'");
    $result = $query->result_array();
    $data_indexed = array();

    foreach ($result as $row) {
    $id = $row['kdoption'];
    unset($row['kdoption']);
    $data_indexed[$id] = $row;
    }

    return $data_indexed;
}

   public function save_token($access_token, $refresh_token=null){

        try {
        
            // Update or insert access token
            $this->db->where('kdoption', 'GO:ACCESS-TOKEN');
            $this->db->update('sc_mst.option', array('value1' => $access_token));

            // Update or insert refresh token if it's not null
            if ($refresh_token != null) {
                $this->db->where('kdoption', 'GO:REFRESH-TOKEN');
                $this->db->update('sc_mst.option', array('value1' => $refresh_token));
            }

            return true;

        } catch (Exception $e) {
            // Log the exception and return false
            log_message('error', 'Error saving tokens: ' . $e->getMessage());
            return false;
        }
}

   public function update_access_token($access_token,$expires_in){
    $data = array(
        'access_token' => $access_token,
        'expires_in' => $expires_in,
        'created_at' => date('Y-m-d H:i:s') 
    );

    return $this->db->update('sc_trx.google_tokens', $data);

   }



}