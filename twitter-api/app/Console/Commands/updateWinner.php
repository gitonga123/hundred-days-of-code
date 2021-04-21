<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SofascoreController;

class updateWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Winner';

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
        $sofa_score->getMatchWinnerBool();
        $this->info('Successfully updated records.');
        return 0;
    }
}
