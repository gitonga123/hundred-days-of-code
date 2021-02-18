<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Twitter;

class TweetsStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:timeline {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull timeline tweets argument user_id to pull timeline for';

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
        $user_id = $this->argument('user_id');
        $twitter = new Twitter($user_id);
        $twitter->index();

        $this->info('Successfully updated records.');
        return 0;
    }
}
