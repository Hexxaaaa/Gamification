<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserTask;
use App\Notifications\TaskReminder;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to users with incomplete tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('is_admin', false)->get();

        foreach ($users as $user) {
            $incompleteTasks = $user->userTasks()->where('status', 'pending')->get();
            if ($incompleteTasks->isNotEmpty()) {
                $user->notify(new TaskReminder($incompleteTasks));
            }
        }

        $this->info('Task reminders have been sent successfully.');
        return 0;
    }
}