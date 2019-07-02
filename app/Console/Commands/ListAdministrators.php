<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListAdministrators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:administrators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all administrators';

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
        $headers = ['Name','Email'];

        $users = User::whereHas('role', function($query){
            $query->where('role_id', 1);
        })->get(['name','email']);

        $this->table($headers,$users); 
    }
}
