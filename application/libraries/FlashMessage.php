<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class FlashMessage {
    protected $ci;
    protected $messages = array();
    function __construct() {
        $this->ci = & get_instance();
    }
    /* $this->FlashMessage->set(array('Hellow', 'warning')) */
    public function set($messages) {
        array_push($this->messages, $messages);
        return $this;
    }
    public function get() {
        $messages = $this->ci->input->get('messages');
        if (!empty($messages)) {
            $messages = json_decode(hex2bin($messages));
        }
        return $messages;
    }
    public function redirect($uri) {
        if ( ! preg_match('#^https?://#i', $uri)) {
            $uri = site_url($uri);
        }
        header('Location: '.$uri.'?messages='.bin2hex(json_encode($this->messages)), TRUE, 302);
        exit;
    }
}
