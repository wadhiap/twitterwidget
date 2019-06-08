<?php

namespace TwitterWebsiteWidget; 

/**
 * Twitter Widget Class
 * 
 * The main class to hold the data and API connector
 */
class TwitterWidget
{
    /**
     * Variable to hold response data
     *
     * @var string
     */
    public $data;

    /**
     * Variable to hold the Twitter API Connector
     *
     * @var TwitterConnectorI
     */
    public $connecter;

    function __construct(TwitterConnectorI $connecter)
    {
        $this->connecter = $connecter;
    }
}

