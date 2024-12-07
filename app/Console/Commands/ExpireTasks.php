<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
class ExpireTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire tasks that have passed their deadline';

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
        Task::where('status', 'active')
        ->where('deadline', '<', now())
        ->update(['status' => 'expired']);
        
        $this->info('Tasks expired successfully');
        return 0;
    }
}