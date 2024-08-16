<?php

namespace Tests\Feature;

use App\Console\Kernel;
use App\Jobs\CheckInProgressTasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_schedules_check_in_progress_tasks_job()
    {
        // Fake the queue to prevent actual job execution
        Queue::fake();

        // Run the schedule:run command
        Artisan::call('schedule:run');

        // Assert that the job was pushed to the queue
        Queue::assertPushed(CheckInProgressTasks::class);
        logger('CheckInProgressTasks job was pushed to the queue');
    }
}
