<?php

namespace TwitterWebsiteWidget; 

/**
 * API Connecter class
 * 
 * An API connecter class which authenticates and queries the API using curl and 0Auth2
 */
class TwitterConnectorAuthOnlyOAuth2Curl implements TwitterConnectorI
{
    /**
     * Variable to hold consumer secret
     *
     * @var string
     */
    private $consumer_secret;

    /**
     * Variable to hold consumer key
     *
     * @var string
     */
    private $consumer_key;

    /**
     * Main constructor
     *
     * @param string $consumer_key
     * @param string $consumer_secret
     */
    function __construct($consumer_key, $consumer_secret)
    {
        $this->consumer_key = $consumer_key; 
        $this->consumer_secret = $consumer_secret;
    }

    /**
     * Query the api
     * 
     * Query the api as specified in Twitter's developer documententation
     * https://developer.twitter.com/en/docs/basics/authentication/overview/application-only.html
     *
     * @param string $query
     * 
     * @return object or 0 on error
     */
    public function query($query)
    {
        if (isset($_SESSION['twitter_token'])) {
            $bearer_token = $_SESSION['twitter_token'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $query);
            $headers = array('Authorization: Bearer '.$bearer_token);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // don't output to page
            $data = curl_exec($ch);
            curl_close($ch);
    
            return json_decode($data);
        }

        return 0;
    }

    /**
     * Api authentication
     * 
     * Authenticate using api as specified in Twitter's developer documententation
     * https://developer.twitter.com/en/docs/basics/authentication/overview/application-only.html
     * 
     * @return object
     */
    public function authenticate()
    {
        $consumer_key = urlencode($this->consumer_key);
        $consumer_secret = urlencode($this->consumer_secret);

        $concatenated_key_secret = $consumer_key.':'.$consumer_secret;
        $concatenated_key_secret = base64_encode($concatenated_key_secret);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/oauth2/token");
        $headers = array('Authorization: Basic '.$concatenated_key_secret,'Content-Type: application/x-www-form-urlencoded;charset=UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $post_fields = 'grant_type=client_credentials';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // don't output to page
        $token = curl_exec($ch);
        curl_close($ch);

        return json_decode($token);
    }
}
