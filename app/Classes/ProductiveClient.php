<?php

namespace App\Classes;

use GuzzleHttp\Client;

class ProductiveClient 
{
    public static function connect()
    {
       return $client = new Client([
            'base_uri' => 'https://api.productive.io/api/v2',
        ]);
    }
}