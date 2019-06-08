<?php

namespace TwitterWebsiteWidget; 

/**
 * Twitter controller class
 * 
 * The controller class which will execute the queries and authenticate if needed.
 */
class TwitterController
{
    /**
     * var to hold main twitter object
     *
     * @var TwitterWidget
     */
    private $twitter;

    /**
     * Main constructor
     *
     * @param TwitterWidget $twitter
     */
    function __construct(TwitterWidget $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Query function
     *
     * This function will query and authenticate using the API connector.
     * 
     * @param string $query
     * 
     * @return void
     */
    public function query($query)
    {
        $data = $this->twitter->connecter->query($query);
      
        // check for no or invalid token. If so try getting another (in case changed)...
        if (isset($data->errors[0]->code) && $data->errors[0]->code == 89 || $data == 0) {
            //invalid or no token. Try get a new token...
            $token_data = $this->twitter->connecter->authenticate();  
      
            if (isset($token_data->errors)) { // still invalid          
                $this->twitter->data = $token_data;
            } else {
                $token = $token_data->access_token;         
                $_SESSION['twitter_token'] = $token;
                $data = $this->twitter->connecter->query($query);
            }
        }

        if ($data != 0) {
            $this->twitter->data = $data;
        }
    }
}
