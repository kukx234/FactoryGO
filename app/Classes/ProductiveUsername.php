<?php

namespace App\Classes;

use GuzzleHttp\Client;

class ProductiveUsername
{
    public static function getUsername($x_auth_token)
    {
        $client = new Client([
            'base_uri' => 'https://api.productive.io/api/v2',
        ]);

        $response = $client->get('/api/v2/users',[
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
                'X-auth-token' => $x_auth_token,
            ],
        ]);

        $data = $response->getBody();

        $json = json_decode($data);
        $username = $json->data[0]->attributes->first_name;
        
        return $username;
    }
}
