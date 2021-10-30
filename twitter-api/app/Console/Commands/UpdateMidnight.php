<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SofascoreController;

class UpdateMidnight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:midnight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Might Scores';

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
        $sofa_score->indexProcessMidnight();
        $this->info('Successfully updated records.');
        return 0;
    }
}
