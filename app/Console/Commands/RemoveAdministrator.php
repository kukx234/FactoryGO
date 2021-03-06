<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserRole;
use App\Classes\UserRoles;

class RemoveAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:administrator {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove administrator role from user';

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
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsEmployee()]);
            $this->info("Email $user->email is no longer administrator");
            }
    }
}
