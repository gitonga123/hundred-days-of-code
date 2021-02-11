<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SofascoreController;

class UpdateSfDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sfdates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert new sf_dates values';

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
     * @return int
     */
    public function handle()
    {
        $sofa_score = new SofascoreController();
        $sofa_score->updateSfDates();
        $this->info('Successfully updated records.');
        return 0;
    }
}
