<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserRole;

class RemoveAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:role {email} {--role=}';

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
            UserRole::where('user_id', $user->id)->update([ 'role_id' => $this->option('role')]);
            if($this->option('role') == 1){
                $this->info("Email $user->email is set as an administrator");

            }elseif ($this->option('role') == 2) {
                $this->info("Email $user->email is set as an Approver");
            
            }else {
                $this->info("Email $user->email is set as an Employee");
            }
        }
    }
}
