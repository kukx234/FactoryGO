<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

session_start();

class ProductiveUser extends ProductiveClient
{
    protected $email;
    protected $password;
    
    public function signUp(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
        
        try {
            $response = $this->connect()->post('/api/v2/sessions',[
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
            ]);;
            $data = $response->getBody();
            $json = json_decode($data);
            $_SESSION['x_auth_token'] = $json->data->attributes->token;
           
            
            $status_code = $response->getStatusCode();
    
            if($status_code === 201){

                $user = User::where('email', '=' , $this->email)->first();
                $username = $this->getUser();

                if(!$user){       
                    $createUser = $this->create([
                        'email' => $this->email,
                        'name' => $username,
                        'x_auth_token' => $_SESSION['x_auth_token'] ,
                        'organization_id' => $_SESSION['organization_id'],
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

    public function getUser()
    {
        $response = $this->connect()->get('/api/v2/users',[
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
                'X-auth-token' => $_SESSION['x_auth_token'],
            ],
        ]);

        $data = $response->getBody();
        $json = json_decode($data);

        $_SESSION['organization_id']= $json->data[0]->attributes->default_organization_id;
        $username = $json->data[0]->attributes->first_name;

        return $username;
    }


    public static function create(array $data)
    {
        $user = User::where('email', '=' , $data['email'])->first();

        if(!$user){
            return User::create([
                'email' => $data['email'],
                'name'  => $data['name'],
                'role' => 3,
            ]);
        }else{
           return redirect()->route('addUser')->with([
               'Error' => 'User already exists',
           ]);
        }
    }

    public static function searchProductiveUsers()
    {
        $user = User::where('email', '=', Auth::user()->email)->first();

        $response = self::connect()->get('/api/v2/people',[
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
                'X-auth-token' => $_SESSION['x_auth_token'],
                'x-organization-id' => $_SESSION['organization_id'],
            ],
        ]);

        $data = $response->getBody();
        $json = json_decode($data);
        $allUsers = $json->data;
        
        return $allUsers;
    }
}
