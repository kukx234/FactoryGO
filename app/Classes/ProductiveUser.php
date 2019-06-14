<?php 

namespace App\Classes;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProductiveUser 
{
    protected $email;
    protected $password;
    protected $organization_id;

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
            $token = $json->data->attributes->token;
            
            $status_code = $response->getStatusCode();
    
            if($status_code === 201){

                $user = User::where('email', '=' , $this->email)->first();

                if(!$user){

                    $username = $this->getUser($token);
                    
                    $createUser = $this->create([
                        'email' => $this->email,
                        'name' => $username,
                        'x_auth_token' => $token,
                        'organization_id' => $this->organization_id,
                    ]);

                    Auth::login($createUser);
                    return $status_code;

                }else if(Auth::loginUsingId($user->id)){
                    return $status_code;
                }
            }
            

        } catch (\GuzzleHttp\Exception\ClientException  $th) {

            $status_code = $th->getResponse()->getStatusCode();
            return $status_code;
        }

    }

    public function getUser($token)
    {
        $client = new Client([
            'base_uri' => 'https://api.productive.io/api/v2',
        ]);

        $response = $client->get('/api/v2/users',[
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
                'X-auth-token' => $token,
            ],
        ]);

        $data = $response->getBody();
        $json = json_decode($data);

        $this->organization_id = $json->data[0]->attributes->default_organization_id;
        $username = $json->data[0]->attributes->first_name;
        

        return $username;
    }


    public static function create(array $data)
    {
        if(!array_key_exists('x_auth_token', $data)){
            $data['x_auth_token'] = null;
            $data['organization_id'] = null;
        }

        $user = User::where('email', '=' , $data['email'])->first();

        if(!$user){
            return User::create([
                'email' => $data['email'],
                'name'  => $data['name'],
                'x_auth_token' => $data['x_auth_token'],
                'organization_id' => $data['organization_id'],
            ]);
        }else{
            return redirect()->back()->with([
                'Error' => 'User already exists',
            ]);
        }
    }

    public static function searchProductiveUsers()
    {
        $user = User::where('email', '=', Auth::user()->email)->first();

        $client = new Client([
            'base_uri' => 'https://api.productive.io/api/v2',
        ]);

        $response = $client->get('/api/v2/people',[
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
                'X-auth-token' => $user->x_auth_token,
                'x-organization-id' => $user->organization_id,
            ],
        ]);

        $data = $response->getBody();
        $json = json_decode($data);
        $allUsers = $json->data;
        
        return $allUsers;
    }
}
