<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SofascoreController;

class ProcessMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:match';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process match - run the command to process pulling data from the api';

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
        $sofa_score->index();
        $this->info('Successfully updated records.');
        return 0;
    }
}
