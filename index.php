<?php

    require('lib/Scribe.php');

    $config = array(
        'instance' => 'http://example.com/sendy',  //Your Sendy installation
        'api_key' => 'your_api_key', //your API key is available in Settings
        'list_id' => 'your_list_id'
    );

    $scribe = new Scribe($config);