<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\UserRoles;
use App\Models\User;
use App\Models\UserRole;

class SetAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Administrator role to the user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();

        if(!$user){
            $errorEmail = $this->argument('email');
            $this->error("Email $errorEmail does not exists in our database, please check email");
        }else{
            if($user->status === 'Pending'){
                User::where('email', $this->argument('email'))->update(['status' => 'Active']);
            }
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsAdmin()]);
            $this->info("Email $user->email is set as Admin");
            }
    }
}
