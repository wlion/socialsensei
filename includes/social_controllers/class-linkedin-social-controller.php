<?php
require_once plugin_dir_path(dirname(__FILE__)) . '/class-social-sensei-social-controller.php';

/**
  * Controller for LinkedIn integration
  */
  class Linkedin_Social_Controller extends Social_Sensei_Social_Controller {
    const AUTHORIZATION_URL = 'https://www.linkedin.com/oauth/v2/authorization';
    const ACCESS_TOKEN_URL  = 'https://www.linkedin.com/oauth/v2/accessToken';
    const API_BASE_URL      = 'https://api.linkedin.com/v2/';
    const STATE_COOKIE_NAME = 'social_sensei_li_state';
    
    public function __construct($client_id, $redirect_uri) {
        parent::__construct($client_id, $redirect_uri);
    }

    public static function getRandomStateString($length = 10) {
        $prefix = 'li_';
        $random_string = parent::getRandomStateString($length - strlen($prefix));

        return $prefix . $random_string;
    }
    
    /**
     * Get authorization URL for LinkedIn
     */
    public function getAuthorizationUrl() {
        $params = [
            'response_type' => 'code',
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->redirect_uri,
            'scope'         => 'openid,email,profile,w_member_social'
        ];

        if (isset($_COOKIE[self::STATE_COOKIE_NAME]) && !empty($_COOKIE[self::STATE_COOKIE_NAME])) {
            $params['state'] = $_COOKIE[self::STATE_COOKIE_NAME];
        } 

        return self::AUTHORIZATION_URL . '?' . http_build_query($params);
    }
    
    /**
     * Get access token from LinkedIn
     */
    public function getAccessToken($code) {
        $params = [
            'code'          => $code,
            'callback_uri'  => $this->redirect_uri
        ];
        $jsonData = json_encode($params);
        $url      = HAHN_API_BASE_URL . '/wp-json/hahn-site-utilities/v1/li-access-token';
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData),
                'Authorization: Bearer ' . HAHN_API_BEARER
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function apiRequest($endpoint, $method = 'GET', $params = array(), $headers = array()) {
        $url = self::API_BASE_URL . $endpoint;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    /**
     * Get User info.  Primarily used for getting the user's unique ID.
     * Can be extended to show more info in admin if we need it to
     */
    public function getUserInfo() {
        $url = self::API_BASE_URL . 'userinfo';
        $response = $this->apiRequest($url);
        return $response['sub'];
    }
    
    /**
     * Share a post to LinkedIn
     */
    public function sharePost($title, $url, $summary, $image_url) {
        $url = self::API_BASE_URL . 'shares';
        $params = [
            'content' => [
                'title' => $title,
                'contentEntities' => [
                    [
                        'entityLocation' => $image_url
                    ]
                ],
                'shareCommentary' => [
                    'text' => $summary
                ]
            ],
            'distribution' => [
                'linkedInDistributionTarget' => []
            ]
        ];
        $jsonData = json_encode($params);
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData),
                'Authorization: Bearer ' . $this->access_token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}
