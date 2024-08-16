<?php

namespace App\Jobs;

use App\Mail\InProgressTaskNotification;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckInProgressTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all tasks with status 'in progress'
        $tasksInProgress = Task::where('status', 'in progress')->get();

        foreach ($tasksInProgress as $task) {
            $user = $task->user;

            // Send email to the user
            Mail::to($user->email)->send(new InProgressTaskNotification($task));
        }
        // logger('CheckInProgressTasks job ran successfully');
    }
}
