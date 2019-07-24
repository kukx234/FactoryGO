<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Classes\VacationQuerys;

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
       VacationQuerys::addVacationDays();
    }
}
