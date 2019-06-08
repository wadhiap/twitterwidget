<?php

namespace TwitterWebsiteWidget; 

/**
 * API Connector Interface
 * 
 * An interface to be used by various API connector classes  
 */
interface TwitterConnectorI
{
    function query($query);

    function authenticate();
}
