<?php 

class Auth extends MX_Controller
{
    public function __construct() {
            parent::__construct();
            $this->load->model('Api/M_token_google');
            $this->option = $this->M_token_google->get_token_credential();
        }


    public function index() {

        $params = array(
            'response_type' => 'code',
            'client_id'     => $this->option['GO:CLIENTID']['value1'],
            'redirect_uri'  => $this->option['GO:REDIRECT_URI']['value1'],
            'scope'         => 'https://www.googleapis.com/auth/calendar.events',
            'prompt'        => 'consent',
            'access_type'   => 'offline'
        );

        // Buat URL dengan http_build_query supaya encoding aman
        $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);

        // Redirect ke Google OAuth URL
        header('Location: ' . $auth_url);
        exit;
    }
    

    public function callback(){
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $token_url = "https://oauth2.googleapis.com/token";
            $post_fields = array(
                'code' => $code,
                'client_id' => $this->option['GO:CLIENTID']['value1'],
                'client_secret' => $this->option['GO:CLIENTSECRET']['value1'],
                'redirect_uri' => $this->option['GO:REDIRECT_URI']['value1'],
                'grant_type' => 'authorization_code'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $token_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            if (isset($data['access_token'])) {
                $refresh_token = isset($data['refresh_token']) ? $data['refresh_token'] : null;
                $this->M_token_google->save_token($data['access_token'], $refresh_token);
                $_SESSION['access_token'] = $data['access_token'];
                //print_r($data);
                echo "Login berhasil! Access Token: " . $data['access_token'] . "<br>" ." Refresh Token: " . $refresh_token;
            } else {
                echo "Gagal mendapatkan access token.";
            }
        } else {
            echo "Tidak ada kode yang diterima.";
        }
    }

    public function get_token_valid() {
       
            // Token expired → refresh
            $post = array(
                'client_id'     => $this->option['GO:CLIENTID']['value1'],
                'client_secret' => $this->option['GO:CLIENTSECRET']['value1'],
                'refresh_token' => $this->option['GO:REFRESH-TOKEN']['value1'],
                'grant_type'    => 'refresh_token'
            );

            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);

            if (isset($data['access_token'])) {
                // Update ke DB
                $this->M_token_google->save_token($data['access_token']);
                return $data['access_token'];
            } else {
                // Gagal refresh
                return false;
            }
    }

    private function is_token_expired($token) {
        $created    = strtotime($token['token_created_at']);
        $expired_at = $created + intval($token['expires_in']) - 60; // Kasih buffer 1 menit
        return (time() >= $expired_at);
    }



}



?>