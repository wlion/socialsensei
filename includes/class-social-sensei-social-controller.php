<?php

/**
 * Base controller for handling social media integrations
 */

 class Social_Sensei_Social_Controller {
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    
    // Constructor to set credentials
    public function __construct($client_id, $client_secret, $redirect_uri) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }
    
    // Method to get OAuth2 authorization URL
    public function getAuthorizationUrl() {
        // To be implemented in child classes
    }
    
    // Method to exchange authorization code for access token
    public function getAccessToken($code) {
        // To be implemented in child classes
    }
    
    // Method to make authenticated API requests
    public function apiRequest($url, $method = 'GET', $params = array(), $headers = array()) {
        // To be implemented in child classes
    }
 }