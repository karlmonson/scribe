<?php

    require('lib/Scribe.php');

    // $config = array(
    //     'instance' => 'http://example.com/sendy',  //Your Sendy installation
    //     'api_key' => 'your_api_key', //your API key is available in Settings
    //     'list_id' => 'your_list_id'
    // );

    $config = array(
        'instance' => 'http://tryecigstoday.com/sendy',  //Your Sendy installation
        'api_key' => 'a8yRF9ghfJLwMrXvQp1u', //your API key is available in Settings
        'list_id' => 'vKTLgs2b8920pNglyRccnpFw'
    );

    $scribe = new Scribe($config);

    $result = $scribe->subscribe(array('email' => 'karlos@santana.com', 'Birthday' => '11/10/1990'));

    echo $result['status'] . ': ' . $result['message'];