<?php

namespace App\Console\Commands;

use App\Events\TaskStatusUpdated;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckTasks extends Command
{
    protected $signature = 'tasks:check';

    protected $description = 'Check and update tasks older than two days';

    public function handle()
    {
        $twoDaysAgo = Carbon::now()->subDays(2);

        Task::where('created_at', '<', $twoDaysAgo)
            ->where('status', '!=', 'done')
            ->chunk(100, function ($tasks) {
                foreach ($tasks as $task) {
                    $task->status = 'done';
                    $task->save();
                    event(new TaskStatusUpdated($task->id, $task->status));
                }
            });
        $this->info('Tasks updated successfully!');
    }
}
