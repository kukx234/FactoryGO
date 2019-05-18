<?php

namespace App\Classes;

use GuzzleHttp\Client;
use App\Classes\ProductiveUsername;
use App\Classes\CreateProductiveUser;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProductiveSignUp 
{
    protected $email;
    protected $password;

    public function signUp(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];

        $client = new Client([
            'base_uri' => 'https://api.productive.io/api/v2',
        ]);
    
        try {
            $response = $client->post('/api/v2/sessions',[
                'headers' => [
                    'Content-Type' => 'application/vnd.api+json',
                ],
                'json' => [
                    'data' => [
                        'type' => 'sessions',
                        'attributes' => [
                            'email' => $this->email,
                            'password' => $this->password,
                        ]
                    ]
                ]
            ]);

            $data = $response->getBody();
    
            $json = json_decode($data);
            $x_auth_token = $json->data->attributes->token;

            $status_code = $response->getStatusCode();

            if($status_code === 201){

                $username = ProductiveUsername::getUsername($x_auth_token);

                $user = User::where('email', '=' , $this->email)->first();

                if(!$user){

                    $createUser = CreateProductiveUser::create([
                        'email' => $this->email,
                        'name' => $username,
                    ]);

                    Auth::login($createUser);
                    //return redirect(route('home'));
                    return $status_code;

                }else if(Auth::loginUsingId($user->id)){
                    //return redirect(route('home'));
                    return $status_code;
                }
            }
            

        } catch (\GuzzleHttp\Exception\ClientException  $th) {
            
            $status_code = $th->getResponse()->getStatusCode();

            return $status_code;
        }

    }
}