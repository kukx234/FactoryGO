<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VacationYearly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All unused vacation is saved in old vacation and new vacation is reset';

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
        $users = User::all();
        
        foreach ($users as $user) {
            $user->update([
                'old_vacation' => $user->new_vacation,
                'new_vacation' => 0,
                'requested_days' => 0,
                ]);
            
        }
    }
}
