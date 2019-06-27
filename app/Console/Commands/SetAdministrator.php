<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SetAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:administrator {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set user as an administrator';

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
            $user->update(array('role' => 1));
            $this->info("Email $user->email is set as an administrator");
        }
        
      
        
    }
}
