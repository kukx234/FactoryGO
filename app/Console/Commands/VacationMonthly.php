<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VacationMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add vacation days to the user monthly';

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
            $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $user->created_at->format('d-m-Y'));
            $current_date = \Carbon\Carbon::createFromFormat('d-m-Y', date('d-m-Y'));
            $diff_in_months = $start_date->diffInMonths($current_date);
            $six_months = $diff_in_months / 6;

            if($diff_in_months > 0){
                $user->update(['new_vacation' => $user->new_vacation + 1.67]);

                if($six_months === intval($six_months)){
                    $user->update(['new_vacation' => 20]);
                }
            }
        }
    }
}
