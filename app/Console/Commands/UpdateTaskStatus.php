<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateTaskStatus extends Command
{
    protected $signature = 'tasks:update-status';
    protected $description = 'Update task status based on deadline';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $tasks = Task::where('deadline', '<', $now)->where('status', '!=', 'completed')->get();

        foreach ($tasks as $task) {
            $task->status = 'expired';
            $task->save();
        }

        $this->info('Task statuses updated successfully.');
    }
}